<?php

/* @Framework/Form/form_rows.html.php */
class __TwigTemplate_0f9ae29f54c611f7ffe1210c6a6ab7e49c01c649f2ae0ef8a75c91e74c12d535 extends Twig_Template
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
        $__internal_8d42307d061141b8df4c964838c17c8eac6802c165499b80133d814cf698860f = $this->env->getExtension("native_profiler");
        $__internal_8d42307d061141b8df4c964838c17c8eac6802c165499b80133d814cf698860f->enter($__internal_8d42307d061141b8df4c964838c17c8eac6802c165499b80133d814cf698860f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/form_rows.html.php"));

        // line 1
        echo "<?php foreach (\$form as \$child) : ?>
    <?php echo \$view['form']->row(\$child) ?>
<?php endforeach; ?>
";
        
        $__internal_8d42307d061141b8df4c964838c17c8eac6802c165499b80133d814cf698860f->leave($__internal_8d42307d061141b8df4c964838c17c8eac6802c165499b80133d814cf698860f_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/form_rows.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <?php foreach ($form as $child) : ?>*/
/*     <?php echo $view['form']->row($child) ?>*/
/* <?php endforeach; ?>*/
/* */
