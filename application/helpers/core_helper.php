<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Outputs an array in a user-readable JSON format
 *
 * @param array $array
 */
if (!function_exists('display_json')) {
    function display_json($array)
    {
        $data = json_indent($array);

        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');

        echo $data;
    }
}


/**
 * Convert an array to a user-readable JSON string
 *
 * @param array $array - The original array to convert to JSON
 * @return string - Friendly formatted JSON string
 */
if (!function_exists('json_indent')) {
    function json_indent($array = array())
    {
        // make sure array is provided
        if (empty($array))
            return NULL;

        //Encode the string
        $json = json_encode($array);

        $result = '';
        $pos = 0;
        $str_len = strlen($json);
        $indent_str = '  ';
        $new_line = "\n";
        $prev_char = '';
        $out_of_quotes = true;

        for ($i = 0; $i <= $str_len; $i++) {
            // grab the next character in the string
            $char = substr($json, $i, 1);

            // are we inside a quoted string?
            if ($char == '"' && $prev_char != '\\') {
                $out_of_quotes = !$out_of_quotes;
            }
            // if this character is the end of an element, output a new line and indent the next line
            elseif (($char == '}' OR $char == ']') && $out_of_quotes) {
                $result .= $new_line;
                $pos--;

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indent_str;
                }
            }

            // add the character to the result string
            $result .= $char;

            // if the last character was the beginning of an element, output a new line and indent the next line
            if (($char == ',' OR $char == '{' OR $char == '[') && $out_of_quotes) {
                $result .= $new_line;

                if ($char == '{' OR $char == '[') {
                    $pos++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indent_str;
                }
            }

            $prev_char = $char;
        }

        // return result
        return $result . $new_line;
    }
}


/**
 * Save data to a CSV file
 *
 * @param array $array
 * @param string $filename
 * @return bool
 */
if (!function_exists('array_to_csv')) {
    function array_to_csv($array = array(), $filename = "export.csv")
    {
        $CI = get_instance();

        // disable the profiler otherwise header errors will occur
        $CI->output->enable_profiler(FALSE);

        if (!empty($array)) {
            // ensure proper file extension is used
            if (!substr(strrchr($filename, '.csv'), 1)) {
                $filename .= '.csv';
            }

            try {
                // set the headers for file download
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-type: text/csv");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename={$filename}");

                $output = @fopen('php://output', 'w');

                // used to determine header row
                $header_displayed = FALSE;

                foreach ($array as $row) {
                    if (!$header_displayed) {
                        // use the array keys as the header row
                        fputcsv($output, array_keys($row));
                        $header_displayed = TRUE;
                    }

                    // clean the data
                    $allowed = '/[^a-zA-Z0-9_ %\|\[\]\.\(\)%&-]/s';
                    foreach ($row as $key => $value) {
                        $row[$key] = preg_replace($allowed, '', $value);
                    }

                    // insert the data
                    fputcsv($output, $row);
                }

                fclose($output);

            } catch (Exception $e) {
            }
        }

        exit;
    }
}


/**
 * Generates a random password
 *
 * @return string
 */
if (!function_exists('generate_random_password')) {
    function generate_random_password()
    {
        $characters = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alpha_length = strlen($characters) - 1;

        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alpha_length);
            $pass[] = $characters[$n];
        }

        return implode($pass);
    }
}


/**
 * Retrieves list of language folders
 *
 * @return array
 */
if (!function_exists('get_languages')) {
    function get_languages()
    {
        $CI = get_instance();

        if ($CI->session->languages) {
            return $CI->session->languages;
        }

        $CI->load->helper('directory');

        $language_directories = directory_map(APPPATH . '/language/', 1);

        if (!$language_directories) {
            $language_directories = directory_map(BASEPATH . '/language/', 1);
        }

        $languages = array();
        foreach ($language_directories as $language) {
            if (substr($language, -1) == "/" || substr($language, -1) == "\\") {
                $languages[substr($language, 0, -1)] = ucwords(str_replace(array('-', '_'), ' ', substr($language, 0, -1)));
            }
        }

        $CI->session->languages = $languages;

        return $languages;
    }
}


// ------------------------------------------------------------------------


/**
 * Convert name image.jpg to image_thumb.jpg
 *
 * @param string $image
 */
if (!function_exists('image_to_thumb')) {
    function image_to_thumb($image)
    {
        $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $image = strtolower(pathinfo($image, PATHINFO_FILENAME)) . '_thumb.' . $ext;

        return $image;
    }
}


// ------------------------------------------------------------------------


/**
 * Convert name image.jpg to image_large.jpg
 *
 * @param string $image
 */
if (!function_exists('image_to_large')) {
    function image_to_large($image)
    {
        $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $image = strtolower(pathinfo($image, PATHINFO_FILENAME)) . '_large.' . $ext;
        return $image;
    }
}


// ------------------------------------------------------------------------

if (!function_exists('currency_menu')) {
    /**
     * Currency Menu
     *
     * Generates a drop-down menu of currencies.
     *
     * @param   string  currency
     * @param   string  classname
     * @param   string  menu name
     * @param   mixed   attributes
     * @return  string
     */
    function currency_menu($default = 'USD', $class = 'form-control', $name = 'currencies', $attributes = '')
    {
        $CI =& get_instance();

        $default = ($default === 'USD') ? 'USD' : $default;

        $menu = '<select name="' . $name . '" data-live-search="true"';

        if ($class !== '') {
            $menu .= ' class="' . $class . '"';
        }

        $menu .= _stringify_attributes($attributes) . ">\n";
        $currencies = $CI->db->get('currencies')->result();

        foreach ($currencies as $key => $val) {
            $selected = ($default === $val->iso_code) ? ' selected="selected"' : '';
            $menu .= '<option value="' . $val->iso_code . '"' . $selected . '>' . $val->iso_code . "</option>\n";
        }

        return $menu . '</select>';
    }
}

// ------------------------------------------------------------------------

if (!function_exists('get_default_currency')) {
    /**
     * get_default_currency
     *
     * Fetch default currency
     *
     * @param   string  currency
     * @param   string  classname
     * @param   string  menu name
     * @param   mixed   attributes
     * @return  string
     */
    function get_default_currency($iso_code_only = TRUE)
    {
        $CI =& get_instance();

        $default_currency = $CI->db->select(array(
            'currencies.iso_code',
            'currencies.symbol',
            'currencies.unicode',
            'currencies.position',
        ))
            ->join('currencies', "settings.value = currencies.iso_code")
            ->where(array('settings.name' => 'default_currency'))
            ->get('settings')
            ->row();

        if ($default_currency) {
            if ($iso_code_only)
                return $default_currency->iso_code;

            return $default_currency;
        }

        return $iso_code_only ? 'USD' : NULL;
    }
}

// ------------------------------------------------------------------------

if (!function_exists('email_template_menu')) {
    /**
     * Email Template Menu
     *
     * Generates a drop-down menu of email-templates.
     *
     * @param   string  email_tempalte
     * @param   string  classname
     * @param   string  menu name
     * @param   mixed   attributes
     * @return  string
     */
    function email_template_menu($default = '1', $class = 'form-control', $name = 'email_templates', $attributes = '')
    {
        $CI =& get_instance();

        $default = ($default === '1') ? '1' : $default;

        $menu = '<select name="' . $name . '" data-live-search="true"';

        if ($class !== '') {
            $menu .= ' class="' . $class . '"';
        }

        $menu .= _stringify_attributes($attributes) . ">\n";
        $currencies = $CI->db->get('email_templates')->result();

        foreach ($currencies as $key => $val) {
            $selected = ($default === $val->id) ? ' selected="selected"' : '';
            $menu .= '<option value="' . $val->id . '"' . $selected . '>' . $val->title . "</option>\n";
        }

        return $menu . '</select>';
    }
}

// ------------------------------------------------------------------------

if (!function_exists('tax_menu')) {
    /**
     * tax Menu
     *
     * Generates a drop-down menu of taxes.
     *
     * @param   string  tax
     * @param   string  classname
     * @param   string  menu name
     * @param   mixed   attributes
     * @return  string
     */
    function tax_menu($default = '1', $class = 'form-control', $name = 'taxes', $attributes = '')
    {
        $CI =& get_instance();

        $default = ($default === '1') ? '1' : $default;

        $menu = '<select name="' . $name . '" data-live-search="true"';

        if ($class !== '') {
            $menu .= ' class="' . $class . '"';
        }

        $menu .= _stringify_attributes($attributes) . ">\n";
        $taxes = $CI->db->get('taxes')->result();

        foreach ($taxes as $key => $val) {
            $selected = ($default === $val->id) ? ' selected="selected"' : '';
            $menu .= '<option value="' . $val->id . '"' . $selected . '>' . $val->title . ' (' . $val->rate . ' - ' . $val->rate_type . ') (' . $val->net_price . ')' . "</option>\n";
        }

        return $menu . '</select>';
    }
}

// ------------------------------------------------------------------------

if (!function_exists('language_menu')) {
    /**
     * Language Menu
     *
     * Generates a drop-down menu of languages.
     *
     * @param   string  language
     * @param   string  classname
     * @param   string  menu name
     * @param   mixed   attributes
     * @return  string
     */
    function language_menu($default = 'english', $class = 'form-control', $name = 'currencies', $attributes = '')
    {
        $CI =& get_instance();

        $default = ($default === 'english') ? 'english' : $default;

        $menu = '<select name="' . $name . '" data-live-search="true"';

        if ($class !== '') {
            $menu .= ' class="' . $class . '"';
        }

        $menu .= _stringify_attributes($attributes) . ">\n";
        $languages = get_languages();

        foreach ($languages as $key => $val) {
            $selected = ($default == $key) ? ' selected="selected"' : '';
            $menu .= '<option value="' . $key . '"' . $selected . '>' . $val . "</option>\n";
        }

        return $menu . '</select>';
    }
}

// ------------------------------------------------------------------------

if (!function_exists('action_buttons')) {
    /**
     * Action Buttons
     *
     * Generates a drop-down menu of form actions.
     *
     * @param   string  route
     * @param   string  id
     * @param   string  title
     * @param   string  cont (controller name)
     * @param   array   data
     */
    function action_buttons($route = NULL, $id = NULL, $title = NULL, $cont = NULL, $data = NULL)
    {
        $CI =& get_instance();

        $menu = '<div class="btn-group"><button type="button" class="btn bg-' . $CI->settings->admin_theme . ' btn-xs waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="material-icons">more_vert</i></button>
                    <ul class="dropdown-menu pull-right">';

        if ($route === 'faqs')
            $menu .= '<li><a href="#modal-' . $data->id . '" data-toggle="modal" class="waves-effect waves-block"><i class="material-icons">visibility</i>' . lang('action_view') . '</a></li>';
        elseif ($route === 'custom_fields' || $route === 'groups') {
        } else
            $menu .= '<li><a href="' . site_url("admin/" . $route . "/view/" . $id) . '" class="waves-effect waves-block"><i class="material-icons">visibility</i>' . lang('action_view') . '</a></li>';

        if ($route === 'ebookings' || $route === 'bbookings')
            $menu .= '<li><a href="' . site_url("admin/" . $route . "/view/" . $id . "/invoice") . '" target="_blank" class="waves-effect waves-block"><i class="material-icons">description</i>' . lang('action_view_invoice') . '</a></li>';

        $menu .= '<li><a href="' . site_url("admin/" . $route . "/form/" . $id) . '" class="waves-effect waves-block"><i class="material-icons">edit</i>' . lang('action_edit') . '</a></li>';
        if ($route == 'courses') {
            $menu .= '<li><a href="' . site_url("admin/" . $route . "/lectures/" . $id) . '" class="waves-effect waves-block"><i class="material-icons">list</i>Course Contents</a></li>';

            $menu .= '<li><a href="' . site_url("admin/" . $route . "/users/" . $id) . '" class="waves-effect waves-block"><i class="material-icons">list</i>Active Students</a></li>';
        }

        if ($route == 'users') {
            $menu .= '<li><a href="' . site_url("admin/users/unlock_device/" . $id) . '" class="waves-effect waves-block"><i class="material-icons">lock_open</i>Unlock Device</a></li>';
        }


        if ($route !== 'bbookings' && $route !== 'ebookings' && $route !== 'pages')
            $menu .= '<li role="separator" class="divider"></li>
                        <li><a role="button" class="waves-effect waves-block" onclick="ajaxDelete(`' . $id . '`, `' . $title . '`, `' . $cont . '`)"><i class="material-icons">delete_forever</i>' . lang('action_delete') . '</a></li>';

        $menu .= '</ul>
                </div>';

        if ($route === 'faqs')
            $menu .= modal_faq($data);

        return $menu;
    }
}
function action_buttons_lecture($route = NULL, $id = NULL, $title = NULL, $cont = NULL, $data = NULL)
{
    $CI =& get_instance();

    $menu = '<div class="btn-group"><button type="button" class="btn bg-' . $CI->settings->admin_theme . ' btn-xs waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="material-icons">more_vert</i></button>
                    <ul class="dropdown-menu pull-right">';
    $menu .= '<li><a href="' . site_url("admin/courses/lecture_form/" . $data . '/' . $id) . '" class="waves-effect waves-block"><i class="material-icons">visibility</i>' . lang('action_view') . '</a></li>';


    $menu .= '<li><a href="' . site_url("admin/courses/lecture_form/" . $data . '/' . $id) . '" class="waves-effect waves-block"><i class="material-icons">edit</i>' . lang('action_edit') . '</a></li>';
    $menu .= '<li role="separator" class="divider"></li>
                        <li><a role="button" class="waves-effect waves-block" onclick="ajaxDelete(`' . $id . '`, `' . $title . '`, `' . $cont . '`)"><i class="material-icons">delete_forever</i>' . lang('action_delete') . '</a></li>';

    $menu .= '</ul>
                </div>';

    return $menu;
}
function action_buttons_users($route = NULL, $id = NULL, $title = NULL, $cont = NULL, $data = NULL)
{
    $CI =& get_instance();

    $menu = '<div class="btn-group"><button type="button" class="btn bg-' . $CI->settings->admin_theme . ' btn-xs waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="material-icons">more_vert</i></button>
                    <ul class="dropdown-menu pull-right">';



    $menu .= '<li><a href="' . site_url("admin/courses/user_form/" . $data . '/' . $id) . '" class="waves-effect waves-block"><i class="material-icons">edit</i>' . lang('action_edit') . '</a></li>';
    $menu .= '<li role="separator" class="divider"></li>
                        <li><a role="button" class="waves-effect waves-block" onclick="ajaxDeleteUser(`' . $id . '`, `' . $title . '`, `' . $cont . '`)"><i class="material-icons">delete_forever</i>' . lang('action_delete') . '</a></li>';

    $menu .= '</ul>
                </div>';

    return $menu;
}
function lecture_type($type = NULL)
{
    $CI =& get_instance();

    $menu = '';
    if ($type == '1') {
        $menu .= '<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56 56" style="enable-background:new 0 0 56 56;width: 50px;height: 50px;" xml:space="preserve">
            <g>
                <path style="fill:#E9E9E0;" d="M36.985,0H7.963C7.155,0,6.5,0.655,6.5,1.926V55c0,0.345,0.655,1,1.463,1h40.074   c0.808,0,1.463-0.655,1.463-1V12.978c0-0.696-0.093-0.92-0.257-1.085L37.607,0.257C37.442,0.093,37.218,0,36.985,0z"/>
                <path style="fill:#FF5364;" d="M48.037,56H7.963C7.155,56,6.5,55.345,6.5,54.537V39h43v15.537C49.5,55.345,48.845,56,48.037,56z"/>
                <g>
                    <path style="fill:#FFFFFF;" d="M22.4,42.924h1.668V53H22.4v-6.932l-2.256,5.605h-1.449l-2.27-5.605V53h-1.668V42.924h1.668    l2.994,6.891L22.4,42.924z"/>
                    <path style="fill:#FFFFFF;" d="M28.211,53H26.57V42.924h2.898c0.428,0,0.852,0.068,1.271,0.205    c0.419,0.137,0.795,0.342,1.128,0.615c0.333,0.273,0.602,0.604,0.807,0.991s0.308,0.822,0.308,1.306    c0,0.511-0.087,0.973-0.26,1.388c-0.173,0.415-0.415,0.764-0.725,1.046c-0.31,0.282-0.684,0.501-1.121,0.656    s-0.921,0.232-1.449,0.232h-1.217V53z M28.211,44.168v3.992h1.504c0.2,0,0.398-0.034,0.595-0.103    c0.196-0.068,0.376-0.18,0.54-0.335s0.296-0.371,0.396-0.649c0.1-0.278,0.15-0.622,0.15-1.032c0-0.164-0.023-0.354-0.068-0.567    c-0.046-0.214-0.139-0.419-0.28-0.615c-0.142-0.196-0.34-0.36-0.595-0.492c-0.255-0.132-0.593-0.198-1.012-0.198H28.211z"/>
                    <path style="fill:#FFFFFF;" d="M38.479,50.648h-4.361V49.35l4.361-6.426h1.668v6.426h1.053v1.299h-1.053V53h-1.668V50.648z     M38.479,49.35v-4.512L35.58,49.35H38.479z"/>
                </g>
                <path style="fill:#C8BDB8;" d="M24.5,28c-0.166,0-0.331-0.041-0.481-0.123C23.699,27.701,23.5,27.365,23.5,27V13   c0-0.365,0.199-0.701,0.519-0.877c0.321-0.175,0.71-0.162,1.019,0.033l11,7C36.325,19.34,36.5,19.658,36.5,20   s-0.175,0.66-0.463,0.844l-11,7C24.874,27.947,24.687,28,24.5,28z M25.5,14.821v10.357L33.637,20L25.5,14.821z"/>
                <path style="fill:#C8BDB8;" d="M28.5,35c-8.271,0-15-6.729-15-15s6.729-15,15-15s15,6.729,15,15S36.771,35,28.5,35z M28.5,7   c-7.168,0-13,5.832-13,13s5.832,13,13,13s13-5.832,13-13S35.668,7,28.5,7z"/>
                <polygon style="fill:#D9D7CA;" points="37.5,0.151 37.5,12 49.349,12  "/>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            </svg></span>';
    }

    return $menu;
}

// ------------------------------------------------------------------------


if (!function_exists('status_switch')) {
    /**
     * Status Switch
     *
     * Generates a switch for status update.
     *
     * @param   string  status
     * @param   string  id
     */
    function status_switch($status = NULL, $id = NULL)
    {
        $CI =& get_instance();

        $switch = '<div class="switch">';

        $switch .= '<label><input type="checkbox" onchange="statusUpdate(this, `' . $id . '`)" ' . ($status == 1 ? 'checked' : '') . '><span class="lever switch-col-' . $CI->settings->admin_theme . '"></span></label>';

        $switch .= '</div>';

        return $switch;
    }
}
function user_detials($id)
{
    $CI =& get_instance();
    $result = $CI->db->where('id', $id)->get('users')->row_array();
    if (!$result) {
        return '';
    }
    return '<span><img src="' . base_url('upload/users/images/' . str_replace('.jpg', '', ($result['image'] ?? '')) . '_thumb.jpg') . '" width="48" height="48" alt="User Image" style="    border-radius: 50%;
    margin: 0px 17px;"></span><span>' . ($result['username'] ?? '') . '<span>';
}
function status_switch_lecture($status = NULL, $id = NULL)
{
    $CI =& get_instance();
    // return $status;

    $switch = '<div class="switch">';

    $switch .= '<label><input type="checkbox" onchange="statusUpdatesecure(this, `' . $id . '`)" ' . ($status == 1 ? 'checked' : '') . '><span class="lever switch-col-' . $CI->settings->admin_theme . '"></span></label>';

    $switch .= '</div>';

    return $switch;
}
// ------------------------------------------------------------------------


if (!function_exists('featured_switch')) {
    /**
     * Featured Switch
     *
     * Generates a switch for featured update.
     *
     * @param   string  status
     * @param   string  id
     */
    function featured_switch($featured = NULL, $id = NULL)
    {
        $CI =& get_instance();

        $switch = '<div class="switch">';

        $switch .= '<label><input type="checkbox" onchange="featuredUpdate(this, `' . $id . '`)" ' . ($featured == 1 ? 'checked' : '') . '><span class="lever switch-col-' . $CI->settings->admin_theme . '"></span></label>';

        $switch .= '</div>';

        return $switch;
    }
}



// ------------------------------------------------------------------------


if (!function_exists('modal_contact')) {
    /**
     * Modal Contact
     *
     * Generates a modal for contact.
     *
     * @param   object  data
     */
    function modal_contact($data)
    {
        $CI =& get_instance();

        $modal = '<a href="#modal-' . $data->id . '" data-toggle="modal" class="btn ' . ($data->read ? 'btn-default' : 'bg-' . $CI->settings->admin_theme) . ' btn-circle waves-effect waves-circle waves-float"><i class="material-icons">' . ($data->read ? 'drafts' : 'email') . '</i></a>';

        $modal .= '<div class="modal fade" id="modal-' . $data->id . '" data-read="' . ($data->read ? "true" : "false") . '" data-id="' . $data->id . '" tabindex="-1" role="dialog" aria-labelledby="modal-label-' . $data->id . '">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal-label-' . $data->id . '">' . $data->title . '</h4>
                            </div>
                            <div class="modal-body">
                                ' . $data->message . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">' . lang('action_cancel') . '</button>
                            </div>
                        </div>
                    </div>
                </div>';

        return $modal;
    }
}

// ------------------------------------------------------------------------


if (!function_exists('modal_faq')) {
    /**
     * Modal Faq
     *
     * Generates a modal for faq.
     *
     * @param   object  data
     */
    function modal_faq($data)
    {
        $CI =& get_instance();

        $modal = '<div class="modal fade" id="modal-' . $data->id . '" data-id="' . $data->id . '" tabindex="-1" role="dialog" aria-labelledby="modal-label-' . $data->id . '">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal-label-' . $data->id . '">' . $data->question . '</h4>
                            </div>
                            <div class="modal-body">
                                ' . $data->answer . '
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">' . lang('action_cancel') . '</button>
                            </div>
                        </div>
                    </div>
                </div>';

        return $modal;
    }
}

// ------------------------------------------------------------------------


if (!function_exists('time_elapsed_string')) {
    /**
     * Time Elapsed
     *
     * Timestamp To Time Elapsed.
     *
     * @param   object  data
     */
    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full)
            $string = array_slice($string, 0, 1);

        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}


// ------------------------------------------------------------------------


if (!function_exists('get_domain')) {
    /**
     * Get Domain
     *
     * return domain name.
     *
     * @param   object  data
     */

    function get_domain()
    {
        $CI =& get_instance();
        return preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/", "$1", $CI->config->slash_item('base_url'));
    }

}

// ------------------------------------------------------------------------


if (!function_exists('get_date_difference')) {
    /**
     * Get Domain
     *
     * return domain name.
     *
     * @param   object  data
     */

    function get_date_difference($date_small, $date_big)
    {
        $diff = abs(strtotime($date_big) - strtotime($date_small));

        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

        $result = '';

        if ($years) {
            if ($years > 1)
                $result .= $years . ' Years, ';
            else
                $result .= $years . ' Year, ';
        }

        if ($months) {
            if ($years > 1)
                $result .= $months . ' Months, ';
            else
                $result .= $years . ' Month, ';
        }

        if ($days) {
            if ($days > 1)
                $result .= $days . ' Days';
            else
                $result .= $days . ' Day';
        }

        return $result;
    }

}

// ------------------------------------------------------------------------
