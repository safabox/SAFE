<?php

/* @Framework/Form/radio_widget.html.php */
class __TwigTemplate_21f005eb50689d15e0519f7e2ff39717e31d73603cae171e32675a4457c9c476 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_daa7d9f7e99e8be576eced1ecea294666f956a85553009ba530504ff12c9a6ee = $this->env->getExtension("native_profiler");
        $__internal_daa7d9f7e99e8be576eced1ecea294666f956a85553009ba530504ff12c9a6ee->enter($__internal_daa7d9f7e99e8be576eced1ecea294666f956a85553009ba530504ff12c9a6ee_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/radio_widget.html.php"));

        // line 1
        echo "<input type=\"radio\"
    <?php echo \$view['form']->block(\$form, 'widget_attributes') ?>
    value=\"<?php echo \$view->escape(\$value) ?>\"
    <?php if (\$checked): ?> checked=\"checked\"<?php endif ?>
/>
";
        
        $__internal_daa7d9f7e99e8be576eced1ecea294666f956a85553009ba530504ff12c9a6ee->leave($__internal_daa7d9f7e99e8be576eced1ecea294666f956a85553009ba530504ff12c9a6ee_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/radio_widget.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <input type="radio"*/
/*     <?php echo $view['form']->block($form, 'widget_attributes') ?>*/
/*     value="<?php echo $view->escape($value) ?>"*/
/*     <?php if ($checked): ?> checked="checked"<?php endif ?>*/
/* />*/
/* */
