<?php

/* @Framework/Form/choice_widget_expanded.html.php */
class __TwigTemplate_0dee7f00b94fbc847fe73fe2160fe0e83a59313875a33f2f4d1c809e904266ae extends Twig_Template
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
        $__internal_1ffaf19b0759690e2cb0c63ed17b6ea13673446e85e6d01ff90f6646fdb7b297 = $this->env->getExtension("native_profiler");
        $__internal_1ffaf19b0759690e2cb0c63ed17b6ea13673446e85e6d01ff90f6646fdb7b297->enter($__internal_1ffaf19b0759690e2cb0c63ed17b6ea13673446e85e6d01ff90f6646fdb7b297_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/choice_widget_expanded.html.php"));

        // line 1
        echo "<div <?php echo \$view['form']->block(\$form, 'widget_container_attributes') ?>>
<?php foreach (\$form as \$child): ?>
    <?php echo \$view['form']->widget(\$child) ?>
    <?php echo \$view['form']->label(\$child, null, array('translation_domain' => \$choice_translation_domain)) ?>
<?php endforeach ?>
</div>
";
        
        $__internal_1ffaf19b0759690e2cb0c63ed17b6ea13673446e85e6d01ff90f6646fdb7b297->leave($__internal_1ffaf19b0759690e2cb0c63ed17b6ea13673446e85e6d01ff90f6646fdb7b297_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/choice_widget_expanded.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <div <?php echo $view['form']->block($form, 'widget_container_attributes') ?>>*/
/* <?php foreach ($form as $child): ?>*/
/*     <?php echo $view['form']->widget($child) ?>*/
/*     <?php echo $view['form']->label($child, null, array('translation_domain' => $choice_translation_domain)) ?>*/
/* <?php endforeach ?>*/
/* </div>*/
/* */
