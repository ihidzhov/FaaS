<?php 

namespace Ihidzhov\FaaS;

use Exception;

class Page {

    public function display($template = null, $vars = []) {
        if (!file_exists(TEMPLATES_DIR . $template . '.php')) {
            throw new Exception("Templage \"{$template}.php\" does not exists");
        }
        ob_start();
        extract($vars);
        include TEMPLATES_DIR . $template . '.php';
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
        exit;
    }
}
