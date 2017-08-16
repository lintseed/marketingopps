<?php

// Normal export
function simple_csv_xls_exporter_csv_xls(){

    // Error display will output csv content and script will fail
    if (!ini_get('display_errors') || ini_get('display_errors') == '1') {
        ini_set('display_errors', '0');
    }
	//error_reporting(E_ERROR | E_PARSE);

    global  $ccsve_export_check,
            $export_only;

    // Get the custom post type that is being exported
    $post_type_var = isset($_REQUEST['post_type']) ? $_REQUEST['post_type'] : '';
    if(empty($post_type_var)) {
        $ccsve_generate_post_type = get_option('ccsve_post_type');
    } else {
        $ccsve_generate_post_type = $post_type_var;
    }

    // Get the custom post status that is being exported
    $post_status_var = isset($_REQUEST['post_status']) ? $_REQUEST['post_status'] : '';
    if(empty($post_status_var)) {
        $ccsve_get_option_post_status = get_option('ccsve_post_status');
        $ccsve_generate_post_status = $ccsve_get_option_post_status['selectinput'][0];
    } else {
        $ccsve_generate_post_status = $post_status_var;
    }
    //var_dump($ccsve_generate_post_status); echo $ccsve_generate_post_status; exit;

    // Get only the content from specific user
    if(isset($_REQUEST['user'])) {
        if($_REQUEST['user'] == '') {
            $user_id = intval(get_current_user_id());
        } else {
            $user_id = intval($_REQUEST['user']);
        }
    }
    //echo $user_id;
    //echo get_the_author_meta( 'display_name', $user_id );exit;

    // Get the custom fields (for the custom post type) that are being exported
    $ccsve_generate_custom_fields = get_option('ccsve_custom_fields');
    $ccsve_generate_std_fields = get_option('ccsve_std_fields');
    $ccsve_generate_tax_terms = get_option('ccsve_tax_terms');
    $ccsve_generate_woocommerce_fields = get_option('ccsve_woocommerce_fields');

    // Are we getting only parents or children?
    if($export_only == 'parents') {

        // Query the DB for all instances of the custom post type
        $ccsve_generate_query = new WP_Query( array(
            'post_type' => $ccsve_generate_post_type,
            'post_parent' => 0,
            'post_status' => $ccsve_generate_post_status,
            'posts_per_page' => -1,
            'author' => $user_id,
            'order' => 'ASC',
            //'orderby' => 'name'
        ));

    } elseif($export_only == 'children') {

        // Query the DB for all instances of the custom post type
        $csv_parent_export = new WP_Query( array(
            'post_type' => $ccsve_generate_post_type,
            'post_parent' => 0,
            'post_status' => $ccsve_generate_post_status,
            'posts_per_page' => -1,
            'author' => $user_id
        ));

        $parents_ids_array = array();
        foreach ($csv_parent_export->posts as $post): setup_postdata($post);
            //if($post->post_parent) != 0) {
                $parents_ids_array[] = $post->ID;
            //}
        endforeach;

        $ccsve_generate_query = new WP_Query( array(
            'post_type' => $ccsve_generate_post_type,
            'post_status' => $ccsve_generate_post_status,
            'exclude' => $parents_ids_array,
            'posts_per_page' => -1,
            'author' => $user_id,
            'order' => 'ASC',
            //'orderby' => 'name'
        ));

    } else {

        // Query the DB for all instances of the custom post type
        $ccsve_generate_query = new WP_Query( array(
            'post_type' => $ccsve_generate_post_type,
            'post_status' => $ccsve_generate_post_status,
            'posts_per_page' => -1,
            'author' => $user_id,
            'order' => 'ASC',
            //'orderby' => 'name'
        ));

    }

    //echo '<pre>';    var_dump($ccsve_generate_query);    echo '</pre>'; exit;
    wp_reset_query(); wp_reset_postdata();

    // Count the number of instances of the custom post type
    //$ccsve_count_posts = count($ccsve_generate_query);
    $ccsve_count_posts = $ccsve_generate_query->found_posts;

    // Build an array of the custom field values
    $ccsve_generate_value_arr = array();
    $i = 0;

    foreach ($ccsve_generate_query->posts as $post): setup_postdata($post);

        $post->permalink = get_permalink($post->ID);
        $post->post_thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

        // get the standard wordpress fields for each instance of the custom post type
        if(!empty($ccsve_generate_std_fields['selectinput'])) {
            foreach($post as $key => $value) {
                if(in_array($key, $ccsve_generate_std_fields['selectinput'])) {
                    // Prevent SYLK format issue
                    if($key == 'ID') {
                        // add an apostrophe before ID
                        //$ccsve_generate_value_arr["'".$key][$i] = $post->$key;
                        // or make it lower-case
						//$low_id = strtolower($key);
						$low_id = 'id';
                        $ccsve_generate_value_arr[$low_id][$i] = $post->$key;
                    } else {
                        $ccsve_generate_value_arr[$key][$i] = $post->$key;
                    }
                }
            }
        }

        /*echo '<pre>';
        var_dump($ccsve_generate_value_arr);
        echo '</pre>';
        exit;*/

        // get custom taxonomy information
        if(!empty($ccsve_generate_tax_terms['selectinput'])) {
            foreach($ccsve_generate_tax_terms['selectinput'] as $tax) {
                $names = array();
                $terms = wp_get_object_terms($post->ID, $tax);

                if (!empty($terms)) {
                    if (!is_wp_error( $terms ) ) {
                        foreach($terms as $t) {
                            //echo $t->name;
                            $names[] = htmlspecialchars_decode($t->name);
                        }
                    } else {
                        $names[] = '- error -';
                    }
                } else {
                    $names[] = '';
                }

                $ccsve_generate_value_arr[$tax][$i] = implode(',', $names);
                //echo implode(',', $names);
            }
        }

        // get the custom field values for each instance of the custom post type
        if(!empty($ccsve_generate_custom_fields['selectinput'])) {
            $ccsve_generate_post_values = get_post_custom($post->ID);
            foreach ($ccsve_generate_custom_fields['selectinput'] as $key) {
                // check if each custom field value matches a custom field that is being exported
                if (array_key_exists($key, $ccsve_generate_post_values)) {
                    // if the the custom fields match, save them to the array of custom field values
                    $ccsve_generate_value_arr[$key][$i] = $ccsve_generate_post_values[$key]['0'];
               }
            }
        }

        // get the WooCommerce field values for each instance of the custom post type
        /*$ccsve_generate_post_values = get_post_custom($post->ID);
        foreach ($ccsve_generate_custom_fields['selectinput'] as $key) {
            // check if each custom field value matches a custom field that is being exported
            if (array_key_exists($key, $ccsve_generate_post_values)) {
                // if the the custom fields match, save them to the array of custom field values
                $ccsve_generate_value_arr[$key][$i] = $ccsve_generate_post_values[$key]['0'];
           }
       }*/
        /*if(!empty($ccsve_generate_woocommerce_fields['selectinput']) && class_exists('WC_Product')) {
            global  $woocommerce,
                    $product;
            //$product = wc_get_product( $post->ID );
            $product_id = $product->id;

            $get_all_meta = get_post_meta($product_id);

            // 'sku',
            $price = get_post_meta($product_id, '_price', true);

            'regular_price',
            'sale_price',
            'manage_stock',
            'stock_status',
            'backorders',
            'stock',
            'featured',
            'featured_image',
            'product_gallery'

            // Price
            //$price = get_post_meta($product_id, '_price', true);

            echo '<pre>';
            //var_dump($product);
            //var_dump($price);
            var_dump($get_all_meta);
            echo '</pre>';
            exit;
        }*/

        $i++;

    endforeach;

    //exit;

    // create a new array of values that reorganizes them in a new multidimensional array where each sub-array contains all of the values for one custom post instance
    $ccsve_generate_value_arr_new = array();

    foreach($ccsve_generate_value_arr as $value) {
        $i = 0;
        while ($i <= ($ccsve_count_posts-1)) {
            $ccsve_generate_value_arr_new[$i][] = $value[$i];
            $i++;
        }
    }

    /*echo '<pre>';
    var_dump($ccsve_generate_value_arr );
    echo '</pre>';
    exit;*/

    // CSV

    if ($ccsve_export_check == 'csv') {

        // Delimiter
        $csv_delimiter = get_option('ccsve_delimiter');

        // build a filename based on the post type and the data/time
        $ccsve_generate_csv_filename = SIMPLE_CSV_XLS_EXPORTER_EXTRA_FILE_NAME.$ccsve_generate_post_type.'-'.date('dMY_Hi').'-export.csv';

        //output the headers for the CSV file
        header('Content-Encoding: UTF-8');
        header("Content-type: text/csv; charset=utf-8");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-Disposition: attachment; filename={$ccsve_generate_csv_filename}");
        header("Expires: 0");
        header("Pragma: public");

        echo "\xEF\xBB\xBF"; // UTF-8 BOM

        //open the file stream
        $fh = @fopen( 'php://output', 'w' );

        $headerDisplayed = false;

        foreach ( $ccsve_generate_value_arr_new as $data ) {
            // Add a header row if it hasn't been added yet -- using custom field keys from first array
            if ( !$headerDisplayed ) {
                fputcsv($fh, array_keys($ccsve_generate_value_arr));
                $headerDisplayed = true;
            }

            // Replace tabs, linebreaks and pipes
            /*$data = preg_replace("/\t/", "\\t", $data);
            $data = preg_replace("/\r?\n/", "\\n", $data);
            $data = preg_replace("/|/", "", $data);
            if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';*/

            // Put the data from the new multi-dimensional array into the stream
            fputcsv($fh, $data, $csv_delimiter);
        }

        // Close the file stream
        fclose($fh);
        // Make sure nothing else is sent, our file is done
        exit;

    }

        // PHP

    if ($ccsve_export_check == 'xls') {

        function cleanData(&$str)  {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/\r?\n/", "\\n", $str);
            // replace commas with nothing
            //$str = preg_replace("/,/", "", $str);
            if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            //$str = mb_convert_encoding($str, 'ASCII', 'UTF-8');
        }

        // Check if there are Cyrillic chars
        /*$i = 0;
        foreach ( $ccsve_generate_value_arr_new as $check_array ) {
            array_walk($check_array, 'cleanData');
            foreach ($check_array as $key => $value) {
                $is_russian = preg_match('/&#10[78]\d/', mb_encode_numericentity($value, array(0x0, 0x2FFFF, 0, 0xFFFF), 'UTF-8'));
                if($is_russian == 1) {
                    $i++;
                }
            }
        }
        $is_russian = $i;*/

        // EXCEL .xls - Raises an unavoidable warning http://blogs.msdn.com/b/vsofficedeveloper/archive/2008/03/11/excel-2007-extension-warning.aspx
        $filename = SIMPLE_CSV_XLS_EXPORTER_EXTRA_FILE_NAME.$ccsve_generate_post_type.'-'.date('dMY_Hi').'-export.xls';

        //output the headers for the XLS file
        header('Content-Encoding: UTF-8');
        header("Content-Type: Application/vnd.ms-excel; charset=utf-8");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-Disposition: Attachment; Filename=\"$filename\"");
        header("Expires: 0");
        header("Pragma: public");

        // This works but breaks the xls columns
        /*if($is_russian > 0) {
            echo "\xEF\xBB\xBF";
        }*/

        $flag = false; // Remove field names from the top?
        foreach ( $ccsve_generate_value_arr_new as $data ) {
            if(!$flag) {
                echo implode("\t", array_keys($ccsve_generate_value_arr)) . "\r\n";
                $flag = true;
            }
            array_walk($data, 'cleanData');

            // DEBUG
            // Get encoding format
            //$data_string = implode("\t", array_values($data));
            // echo mb_detect_encoding($data_string);
            // Support for Euro sign
            // http://php.net/manual/en/function.utf8-decode.php
            //iconv("UTF-8", "CP1252", $data)
            //$data_string = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $data_string);
            //$is_russian = preg_match('/&#10[78]\d/', mb_encode_numericentity($data_string, array(0x0, 0x2FFFF, 0, 0xFFFF), 'UTF-8'));
            //$is_russian = preg_match('/&#10[78]\d/', mb_encode_numericentity(implode("\t", array_values($data)), array(0x0, 0x2FFFF, 0, 0xFFFF), 'UTF-8'));
            //var_dump($is_russian);

            // Check for EUR sign
            /*foreach ($data as $key => $value) {
                //iconv("UTF-8", "CP1252", $value);
                //echo 'Original : ', $value, PHP_EOL;
                //echo 'TRANSLIT : ', iconv("UTF-8", "ISO-8859-1//TRANSLIT", $value), PHP_EOL;
                //echo 'IGNORE   : ', iconv("UTF-8", "ISO-8859-1//IGNORE", $value), PHP_EOL;
                //echo 'Plain    : ', iconv("UTF-8", "ISO-8859-1", $value), PHP_EOL;

                $value = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $value);
            }*/

            //if($is_russian > 0) {
                //$data_string = implode("\t", array_values($data));
            //} else {
                // Add Support for special latin characters (but not Cyrillic)
                $data_string = implode("\t", array_map('utf8_decode',array_values($data)));
            //}

            // Final output
            echo $data_string . "\r\n";
        }
        exit;

    }
}
?>
