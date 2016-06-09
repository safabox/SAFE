<?php

/* @Framework/Form/textarea_widget.html.php */
class __TwigTemplate_b451359c9d6a84767b3206253d93479448397281b69f9631e46ce6e2d03cdc4e extends Twig_Template
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
        $__internal_7e8ba70b39f0c867175aa0d31d4ee5a9f94e1bf28c47dfadf34a78b10c711fab = $this->env->getExtension("native_profiler");
        $__internal_7e8ba70b39f0c867175aa0d31d4ee5a9f94e1bf28c47dfadf34a78b10c711fab->enter($__internal_7e8ba70b39f0c867175aa0d31d4ee5a9f94e1bf28c47dfadf34a78b10c711fab_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/textarea_widget.html.php"));

        // line 1
        echo "<textarea <?php echo \$view['form']->block(\$form, 'widget_attributes') ?>><?php echo \$view->escape(\$value) ?></textarea>
";
        
        $__internal_7e8ba70b39f0c867175aa0d31d4ee5a9f94e1bf28c47dfadf34a78b10c711fab->leave($__internal_7e8ba70b39f0c867175aa0d31d4ee5a9f94e1bf28c47dfadf34a78b10c711fab_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/textarea_widget.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <textarea <?php echo $view['form']->block($form, 'widget_attributes') ?>><?php echo $view->escape($value) ?></textarea>*/
/* */
