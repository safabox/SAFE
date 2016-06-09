<?php

/* @Framework/Form/checkbox_widget.html.php */
class __TwigTemplate_be2a1ad9af890f0616ca6940e89bc96b022791224e1e9f770e2bb0327c17e0b4 extends Twig_Template
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
        $__internal_5ac5be3f87f6e90095d63e0c0dcac5a4263ed6e90aba244b91224b5538884778 = $this->env->getExtension("native_profiler");
        $__internal_5ac5be3f87f6e90095d63e0c0dcac5a4263ed6e90aba244b91224b5538884778->enter($__internal_5ac5be3f87f6e90095d63e0c0dcac5a4263ed6e90aba244b91224b5538884778_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/checkbox_widget.html.php"));

        // line 1
        echo "<input type=\"checkbox\"
    <?php echo \$view['form']->block(\$form, 'widget_attributes') ?>
    <?php if (strlen(\$value) > 0): ?> value=\"<?php echo \$view->escape(\$value) ?>\"<?php endif ?>
    <?php if (\$checked): ?> checked=\"checked\"<?php endif ?>
/>
";
        
        $__internal_5ac5be3f87f6e90095d63e0c0dcac5a4263ed6e90aba244b91224b5538884778->leave($__internal_5ac5be3f87f6e90095d63e0c0dcac5a4263ed6e90aba244b91224b5538884778_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/checkbox_widget.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <input type="checkbox"*/
/*     <?php echo $view['form']->block($form, 'widget_attributes') ?>*/
/*     <?php if (strlen($value) > 0): ?> value="<?php echo $view->escape($value) ?>"<?php endif ?>*/
/*     <?php if ($checked): ?> checked="checked"<?php endif ?>*/
/* />*/
/* */
