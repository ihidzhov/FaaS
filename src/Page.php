<?php 

namespace Ihidzhov\FaaS;

use Exception;
use Ihidzhov\FaaS\HTML;
use Ihidzhov\FaaS\Preferences;

class Page {

    protected $siteTheme = Preferences::SITE_THEME_DEFAULT;
    protected $editorTheme = Preferences::EDITOR_THEME_DEFAULT;

    public function display(?string $template = null, array $vars = []) :never {
        if (!file_exists(TEMPLATES_DIR . $template . '.php')) {
            throw new Exception("Templage \"{$template}.php\" does not exists");
        }
        ob_start();
        extract($vars);
        $navigation = HTML::buildNavigation(isset($vars["navigation"]) ? $vars["navigation"] : 1);
        $siteTheme = $this->siteTheme;
        $editorTheme = $this->editorTheme;
        include TEMPLATES_DIR . $template . '.php';
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
        exit;
    }

    public function setSiteTheme($theme) {
        $this->siteTheme = $theme;
    }

    public function setEditorTheme($theme) {
        $this->editorTheme = $theme;
    }

}
