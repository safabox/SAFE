<?php

/* @Framework/FormTable/hidden_row.html.php */
class __TwigTemplate_0bc16a8b36242b856ebb67717f831fd7a09843cdc9dc317bd53083868e750cf9 extends Twig_Template
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
        $__internal_c86268b29914e40f48d0611928e0001145483245a8947c29d63790aef6e1ebfc = $this->env->getExtension("native_profiler");
        $__internal_c86268b29914e40f48d0611928e0001145483245a8947c29d63790aef6e1ebfc->enter($__internal_c86268b29914e40f48d0611928e0001145483245a8947c29d63790aef6e1ebfc_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/FormTable/hidden_row.html.php"));

        // line 1
        echo "<tr style=\"display: none\">
    <td colspan=\"2\">
        <?php echo \$view['form']->widget(\$form) ?>
    </td>
</tr>
";
        
        $__internal_c86268b29914e40f48d0611928e0001145483245a8947c29d63790aef6e1ebfc->leave($__internal_c86268b29914e40f48d0611928e0001145483245a8947c29d63790aef6e1ebfc_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/FormTable/hidden_row.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <tr style="display: none">*/
/*     <td colspan="2">*/
/*         <?php echo $view['form']->widget($form) ?>*/
/*     </td>*/
/* </tr>*/
/* */
