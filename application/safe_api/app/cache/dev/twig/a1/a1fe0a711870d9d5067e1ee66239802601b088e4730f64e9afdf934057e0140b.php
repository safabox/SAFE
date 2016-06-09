<?php

/* @Framework/FormTable/form_row.html.php */
class __TwigTemplate_72ee611596a354e91aeb9e8fd2eeaf5b06381dceffa1db800529473d725f253f extends Twig_Template
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
        $__internal_8218a4ceb3ad7e3a269eef6e5b3b4d9b6ab77bc7fe9a87fd0e9c799e4f64fe04 = $this->env->getExtension("native_profiler");
        $__internal_8218a4ceb3ad7e3a269eef6e5b3b4d9b6ab77bc7fe9a87fd0e9c799e4f64fe04->enter($__internal_8218a4ceb3ad7e3a269eef6e5b3b4d9b6ab77bc7fe9a87fd0e9c799e4f64fe04_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/FormTable/form_row.html.php"));

        // line 1
        echo "<tr>
    <td>
        <?php echo \$view['form']->label(\$form) ?>
    </td>
    <td>
        <?php echo \$view['form']->errors(\$form) ?>
        <?php echo \$view['form']->widget(\$form) ?>
    </td>
</tr>
";
        
        $__internal_8218a4ceb3ad7e3a269eef6e5b3b4d9b6ab77bc7fe9a87fd0e9c799e4f64fe04->leave($__internal_8218a4ceb3ad7e3a269eef6e5b3b4d9b6ab77bc7fe9a87fd0e9c799e4f64fe04_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/FormTable/form_row.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <tr>*/
/*     <td>*/
/*         <?php echo $view['form']->label($form) ?>*/
/*     </td>*/
/*     <td>*/
/*         <?php echo $view['form']->errors($form) ?>*/
/*         <?php echo $view['form']->widget($form) ?>*/
/*     </td>*/
/* </tr>*/
/* */
