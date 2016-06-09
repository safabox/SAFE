<?php

/* @Framework/FormTable/form_widget_compound.html.php */
class __TwigTemplate_2e60088ece0c56df3cb05f3ea6f9b3bb4697181e2b861565f95ac24f2094dc41 extends Twig_Template
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
        $__internal_b2fb149f0940e998ae23495aa8fac9775ec258a5edad62027220bfd70cc64167 = $this->env->getExtension("native_profiler");
        $__internal_b2fb149f0940e998ae23495aa8fac9775ec258a5edad62027220bfd70cc64167->enter($__internal_b2fb149f0940e998ae23495aa8fac9775ec258a5edad62027220bfd70cc64167_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/FormTable/form_widget_compound.html.php"));

        // line 1
        echo "<table <?php echo \$view['form']->block(\$form, 'widget_container_attributes') ?>>
    <?php if (!\$form->parent && \$errors): ?>
    <tr>
        <td colspan=\"2\">
            <?php echo \$view['form']->errors(\$form) ?>
        </td>
    </tr>
    <?php endif ?>
    <?php echo \$view['form']->block(\$form, 'form_rows') ?>
    <?php echo \$view['form']->rest(\$form) ?>
</table>
";
        
        $__internal_b2fb149f0940e998ae23495aa8fac9775ec258a5edad62027220bfd70cc64167->leave($__internal_b2fb149f0940e998ae23495aa8fac9775ec258a5edad62027220bfd70cc64167_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/FormTable/form_widget_compound.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <table <?php echo $view['form']->block($form, 'widget_container_attributes') ?>>*/
/*     <?php if (!$form->parent && $errors): ?>*/
/*     <tr>*/
/*         <td colspan="2">*/
/*             <?php echo $view['form']->errors($form) ?>*/
/*         </td>*/
/*     </tr>*/
/*     <?php endif ?>*/
/*     <?php echo $view['form']->block($form, 'form_rows') ?>*/
/*     <?php echo $view['form']->rest($form) ?>*/
/* </table>*/
/* */
