<?php

/* @Framework/Form/form_widget.html.php */
class __TwigTemplate_cbacf64914d07d00950c87e61ee4a348871346841a28f0e6601b03857d27c777 extends Twig_Template
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
        $__internal_ee19b3b0a936446d8b47749d9eff3103979a7bc08c0b49b068e3191dea38643b = $this->env->getExtension("native_profiler");
        $__internal_ee19b3b0a936446d8b47749d9eff3103979a7bc08c0b49b068e3191dea38643b->enter($__internal_ee19b3b0a936446d8b47749d9eff3103979a7bc08c0b49b068e3191dea38643b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/form_widget.html.php"));

        // line 1
        echo "<?php if (\$compound): ?>
<?php echo \$view['form']->block(\$form, 'form_widget_compound')?>
<?php else: ?>
<?php echo \$view['form']->block(\$form, 'form_widget_simple')?>
<?php endif ?>
";
        
        $__internal_ee19b3b0a936446d8b47749d9eff3103979a7bc08c0b49b068e3191dea38643b->leave($__internal_ee19b3b0a936446d8b47749d9eff3103979a7bc08c0b49b068e3191dea38643b_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/form_widget.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <?php if ($compound): ?>*/
/* <?php echo $view['form']->block($form, 'form_widget_compound')?>*/
/* <?php else: ?>*/
/* <?php echo $view['form']->block($form, 'form_widget_simple')?>*/
/* <?php endif ?>*/
/* */
