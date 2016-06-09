<?php

/* @Framework/Form/form_widget_compound.html.php */
class __TwigTemplate_fbd25e7c2edd24dd2403a28968a38e7b71a1af4ec31fa25c042821a47b13519c extends Twig_Template
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
        $__internal_43d6a9b31ded5fed32f76d0632c31ae800ade1a5fbf7fea29466dcfb6b7fce1f = $this->env->getExtension("native_profiler");
        $__internal_43d6a9b31ded5fed32f76d0632c31ae800ade1a5fbf7fea29466dcfb6b7fce1f->enter($__internal_43d6a9b31ded5fed32f76d0632c31ae800ade1a5fbf7fea29466dcfb6b7fce1f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/form_widget_compound.html.php"));

        // line 1
        echo "<div <?php echo \$view['form']->block(\$form, 'widget_container_attributes') ?>>
    <?php if (!\$form->parent && \$errors): ?>
    <?php echo \$view['form']->errors(\$form) ?>
    <?php endif ?>
    <?php echo \$view['form']->block(\$form, 'form_rows') ?>
    <?php echo \$view['form']->rest(\$form) ?>
</div>
";
        
        $__internal_43d6a9b31ded5fed32f76d0632c31ae800ade1a5fbf7fea29466dcfb6b7fce1f->leave($__internal_43d6a9b31ded5fed32f76d0632c31ae800ade1a5fbf7fea29466dcfb6b7fce1f_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/form_widget_compound.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <div <?php echo $view['form']->block($form, 'widget_container_attributes') ?>>*/
/*     <?php if (!$form->parent && $errors): ?>*/
/*     <?php echo $view['form']->errors($form) ?>*/
/*     <?php endif ?>*/
/*     <?php echo $view['form']->block($form, 'form_rows') ?>*/
/*     <?php echo $view['form']->rest($form) ?>*/
/* </div>*/
/* */
