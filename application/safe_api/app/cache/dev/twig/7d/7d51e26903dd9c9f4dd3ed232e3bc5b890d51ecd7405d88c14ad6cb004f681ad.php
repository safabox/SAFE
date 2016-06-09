<?php

/* @Framework/Form/choice_widget.html.php */
class __TwigTemplate_eef382342613833a1e3f604f2a15e4a51ad28d845a4870c5e2f36c9a941fdd56 extends Twig_Template
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
        $__internal_ca06f5ac37279310f13fd24bb84e7355b0f1b5d7932aaec5c84ddd84334bacbd = $this->env->getExtension("native_profiler");
        $__internal_ca06f5ac37279310f13fd24bb84e7355b0f1b5d7932aaec5c84ddd84334bacbd->enter($__internal_ca06f5ac37279310f13fd24bb84e7355b0f1b5d7932aaec5c84ddd84334bacbd_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/choice_widget.html.php"));

        // line 1
        echo "<?php if (\$expanded): ?>
<?php echo \$view['form']->block(\$form, 'choice_widget_expanded') ?>
<?php else: ?>
<?php echo \$view['form']->block(\$form, 'choice_widget_collapsed') ?>
<?php endif ?>
";
        
        $__internal_ca06f5ac37279310f13fd24bb84e7355b0f1b5d7932aaec5c84ddd84334bacbd->leave($__internal_ca06f5ac37279310f13fd24bb84e7355b0f1b5d7932aaec5c84ddd84334bacbd_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/choice_widget.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <?php if ($expanded): ?>*/
/* <?php echo $view['form']->block($form, 'choice_widget_expanded') ?>*/
/* <?php else: ?>*/
/* <?php echo $view['form']->block($form, 'choice_widget_collapsed') ?>*/
/* <?php endif ?>*/
/* */
