<?php 

namespace Ihidzhov\FaaS;

use Exception;
use Ihidzhov\FaaS\HTML;

class Page {

    public function display(string $template = null, array $vars = []) :never {
        if (!file_exists(TEMPLATES_DIR . $template . '.php')) {
            throw new Exception("Templage \"{$template}.php\" does not exists");
        }
        ob_start();
        extract($vars);
        $navigation = HTML::buildNavigation(isset($vars["navigation"]) ? $vars["navigation"] : 1);
        include TEMPLATES_DIR . $template . '.php';
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
        exit;
    }
}
