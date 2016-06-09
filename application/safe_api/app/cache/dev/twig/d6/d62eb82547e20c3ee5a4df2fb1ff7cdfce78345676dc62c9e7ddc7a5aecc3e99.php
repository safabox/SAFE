<?php

/* @WebProfiler/Profiler/ajax_layout.html.twig */
class __TwigTemplate_49e05c30be7b91d2c761eb9cb87fc84586c3381a5b6dd76fb4c091a8208a22bc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_abf61379330939d0dfc3ccfaa18d60e7ae02efe265bb5ab6ab311015a66fcd6e = $this->env->getExtension("native_profiler");
        $__internal_abf61379330939d0dfc3ccfaa18d60e7ae02efe265bb5ab6ab311015a66fcd6e->enter($__internal_abf61379330939d0dfc3ccfaa18d60e7ae02efe265bb5ab6ab311015a66fcd6e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Profiler/ajax_layout.html.twig"));

        // line 1
        $this->displayBlock('panel', $context, $blocks);
        
        $__internal_abf61379330939d0dfc3ccfaa18d60e7ae02efe265bb5ab6ab311015a66fcd6e->leave($__internal_abf61379330939d0dfc3ccfaa18d60e7ae02efe265bb5ab6ab311015a66fcd6e_prof);

    }

    public function block_panel($context, array $blocks = array())
    {
        $__internal_cd0d12621e582179cb67f9509ec2fced64ab9ca336f076e0949b0d860410780a = $this->env->getExtension("native_profiler");
        $__internal_cd0d12621e582179cb67f9509ec2fced64ab9ca336f076e0949b0d860410780a->enter($__internal_cd0d12621e582179cb67f9509ec2fced64ab9ca336f076e0949b0d860410780a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        echo "";
        
        $__internal_cd0d12621e582179cb67f9509ec2fced64ab9ca336f076e0949b0d860410780a->leave($__internal_cd0d12621e582179cb67f9509ec2fced64ab9ca336f076e0949b0d860410780a_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Profiler/ajax_layout.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  23 => 1,);
    }
}
/* {% block panel '' %}*/
/* */
