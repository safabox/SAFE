<?php

/* @Framework/Form/form_widget_simple.html.php */
class __TwigTemplate_95d37a531f7eefc03adedcfb773c125f7091126cf56c2b26e386514cf502d323 extends Twig_Template
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
        $__internal_809ccb63d7fa30148d2ca9d6a59f3d8adcca9f3e462f34fc70acd6bf8e8e88e8 = $this->env->getExtension("native_profiler");
        $__internal_809ccb63d7fa30148d2ca9d6a59f3d8adcca9f3e462f34fc70acd6bf8e8e88e8->enter($__internal_809ccb63d7fa30148d2ca9d6a59f3d8adcca9f3e462f34fc70acd6bf8e8e88e8_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/form_widget_simple.html.php"));

        // line 1
        echo "<input type=\"<?php echo isset(\$type) ? \$view->escape(\$type) : 'text' ?>\" <?php echo \$view['form']->block(\$form, 'widget_attributes') ?><?php if (!empty(\$value) || is_numeric(\$value)): ?> value=\"<?php echo \$view->escape(\$value) ?>\"<?php endif ?> />
";
        
        $__internal_809ccb63d7fa30148d2ca9d6a59f3d8adcca9f3e462f34fc70acd6bf8e8e88e8->leave($__internal_809ccb63d7fa30148d2ca9d6a59f3d8adcca9f3e462f34fc70acd6bf8e8e88e8_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/form_widget_simple.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <input type="<?php echo isset($type) ? $view->escape($type) : 'text' ?>" <?php echo $view['form']->block($form, 'widget_attributes') ?><?php if (!empty($value) || is_numeric($value)): ?> value="<?php echo $view->escape($value) ?>"<?php endif ?> />*/
/* */
