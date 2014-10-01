<?php

class View {

    protected $variables = array(),
                    $views = array(),
                    $headInfo = array(),
                    $header,
                    $footer;

    public function __construct() {
        $this->header = TMP . "header.tpl.php";
        $this->footer = TMP . "footer.tpl.php";
    }

    public function __set($key, $value) {
        if (!in_array($key, $this->variables)) {
            $this->variables[$key] = $value;
        } else {
            throw new Exception("The key {$key} already exists.");
        }
    }

    public function __get($key) {
        if (array_key_exists($key, $this->variables)) {
            return $this->variables[$key];
        } else {
            throw new Exception("The key {$key} doesn't exists.");
        }
    }

    public function addView($view) {
        $tmp_view = TMP . $view . ".tpl.php";

        if (!file_exists($tmp_view) || !is_readable($tmp_view)) {
            throw new Exception("The file {$tmp_view} doesn't exists or isn't readable.");
        }

        $this->views[] = $tmp_view;
        return $this;
    }

    public function addHeadInfo($type, $src) {
        $line = "";
        switch ($type) {
            case 'stylesheet':
                $line = "<link rel=\"stylesheet\" type=\"text/css\" href=" . $src . " />";
                break;

            case 'script':
                $line = "<script src=" . $src . "></script>";
                break;

            default:
                # code...
                break;
        }

        $this->headInfo[] = $line;
    }

    public function head() {
        if (!empty($this->headInfo)) {
            return implode("\n", $this->headInfo);
        }

        return "";
    }

    public function render() {
        if (is_null($this->header) || is_null($this->footer)) {
            throw new Exception("The header or the footer are missing.");
        }

        extract($this->variables);
        ob_start();
        include($this->header);
        foreach ($this->views as $view) include($view);
        include($this->footer);
        return ob_get_clean();
    }

}