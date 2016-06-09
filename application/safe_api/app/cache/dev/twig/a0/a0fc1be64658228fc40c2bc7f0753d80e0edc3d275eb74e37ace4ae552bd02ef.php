<?php

/* @Framework/Form/form_row.html.php */
class __TwigTemplate_a75e6a53e607137a005a778acea63574eb453afb0db7d5ea5f00c21ff6f7f6bd extends Twig_Template
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
        $__internal_3025d645714494c140c4cab6da86bebf42a09f3c681e39dd101244da7323ed80 = $this->env->getExtension("native_profiler");
        $__internal_3025d645714494c140c4cab6da86bebf42a09f3c681e39dd101244da7323ed80->enter($__internal_3025d645714494c140c4cab6da86bebf42a09f3c681e39dd101244da7323ed80_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/form_row.html.php"));

        // line 1
        echo "<div>
    <?php echo \$view['form']->label(\$form) ?>
    <?php echo \$view['form']->errors(\$form) ?>
    <?php echo \$view['form']->widget(\$form) ?>
</div>
";
        
        $__internal_3025d645714494c140c4cab6da86bebf42a09f3c681e39dd101244da7323ed80->leave($__internal_3025d645714494c140c4cab6da86bebf42a09f3c681e39dd101244da7323ed80_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/form_row.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <div>*/
/*     <?php echo $view['form']->label($form) ?>*/
/*     <?php echo $view['form']->errors($form) ?>*/
/*     <?php echo $view['form']->widget($form) ?>*/
/* </div>*/
/* */
