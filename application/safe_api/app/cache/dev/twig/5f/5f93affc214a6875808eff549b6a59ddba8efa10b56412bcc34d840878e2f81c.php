<?php

/* @Framework/Form/form_enctype.html.php */
class __TwigTemplate_0d1c528fefc9586579de1f388bced1e40f6616c624b68784424a0cb2d7dcbeca extends Twig_Template
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
        $__internal_184e2224a13953c57e0bd6d287d084abcfdfeaf00b8bcfb7d0adc251575970a9 = $this->env->getExtension("native_profiler");
        $__internal_184e2224a13953c57e0bd6d287d084abcfdfeaf00b8bcfb7d0adc251575970a9->enter($__internal_184e2224a13953c57e0bd6d287d084abcfdfeaf00b8bcfb7d0adc251575970a9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/form_enctype.html.php"));

        // line 1
        echo "<?php if (\$form->vars['multipart']): ?>enctype=\"multipart/form-data\"<?php endif ?>
";
        
        $__internal_184e2224a13953c57e0bd6d287d084abcfdfeaf00b8bcfb7d0adc251575970a9->leave($__internal_184e2224a13953c57e0bd6d287d084abcfdfeaf00b8bcfb7d0adc251575970a9_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/form_enctype.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <?php if ($form->vars['multipart']): ?>enctype="multipart/form-data"<?php endif ?>*/
/* */
