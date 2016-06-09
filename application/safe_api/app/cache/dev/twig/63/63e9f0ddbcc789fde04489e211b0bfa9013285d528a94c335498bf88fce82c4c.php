<?php

/* @Framework/Form/datetime_widget.html.php */
class __TwigTemplate_6e844ca5e52bfca367a52da8d677995c74575e37f03e78e8e2dc081814fb1e00 extends Twig_Template
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
        $__internal_cd4f1e9c594352a36b97080d68f2e9fd5d896100933fdf06cd16632ecf5602bc = $this->env->getExtension("native_profiler");
        $__internal_cd4f1e9c594352a36b97080d68f2e9fd5d896100933fdf06cd16632ecf5602bc->enter($__internal_cd4f1e9c594352a36b97080d68f2e9fd5d896100933fdf06cd16632ecf5602bc_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/datetime_widget.html.php"));

        // line 1
        echo "<?php if (\$widget == 'single_text'): ?>
    <?php echo \$view['form']->block(\$form, 'form_widget_simple'); ?>
<?php else: ?>
    <div <?php echo \$view['form']->block(\$form, 'widget_container_attributes') ?>>
        <?php echo \$view['form']->widget(\$form['date']).' '.\$view['form']->widget(\$form['time']) ?>
    </div>
<?php endif ?>
";
        
        $__internal_cd4f1e9c594352a36b97080d68f2e9fd5d896100933fdf06cd16632ecf5602bc->leave($__internal_cd4f1e9c594352a36b97080d68f2e9fd5d896100933fdf06cd16632ecf5602bc_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/datetime_widget.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <?php if ($widget == 'single_text'): ?>*/
/*     <?php echo $view['form']->block($form, 'form_widget_simple'); ?>*/
/* <?php else: ?>*/
/*     <div <?php echo $view['form']->block($form, 'widget_container_attributes') ?>>*/
/*         <?php echo $view['form']->widget($form['date']).' '.$view['form']->widget($form['time']) ?>*/
/*     </div>*/
/* <?php endif ?>*/
/* */
