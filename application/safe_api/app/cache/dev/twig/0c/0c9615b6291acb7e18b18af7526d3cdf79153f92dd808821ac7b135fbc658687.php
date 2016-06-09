<?php

/* @Framework/Form/money_widget.html.php */
class __TwigTemplate_4b66289b45b4c4970973813bfcf80fadb15f614d852382cd4c3923d674a608e3 extends Twig_Template
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
        $__internal_01e51929902dca58bf2fa724d42caa0004991ea887bed8f68b11bfa84b7f157b = $this->env->getExtension("native_profiler");
        $__internal_01e51929902dca58bf2fa724d42caa0004991ea887bed8f68b11bfa84b7f157b->enter($__internal_01e51929902dca58bf2fa724d42caa0004991ea887bed8f68b11bfa84b7f157b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/money_widget.html.php"));

        // line 1
        echo "<?php echo str_replace('";
        echo twig_escape_filter($this->env, (isset($context["widget"]) ? $context["widget"] : $this->getContext($context, "widget")), "html", null, true);
        echo "', \$view['form']->block(\$form, 'form_widget_simple'), \$money_pattern) ?>
";
        
        $__internal_01e51929902dca58bf2fa724d42caa0004991ea887bed8f68b11bfa84b7f157b->leave($__internal_01e51929902dca58bf2fa724d42caa0004991ea887bed8f68b11bfa84b7f157b_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/money_widget.html.php";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <?php echo str_replace('{{ widget }}', $view['form']->block($form, 'form_widget_simple'), $money_pattern) ?>*/
/* */
