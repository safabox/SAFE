<?php

/* WebProfilerBundle:Collector:router.html.twig */
class __TwigTemplate_f5e62ceaf5ea6c6f7a3bae3c6101e8d773608db2ba9907d52a5ba32bd1c88af5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "WebProfilerBundle:Collector:router.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_ec5a42981c2f236cec0ffa08035f0233d5454327e5647c49ecdb5a2d69e37a5a = $this->env->getExtension("native_profiler");
        $__internal_ec5a42981c2f236cec0ffa08035f0233d5454327e5647c49ecdb5a2d69e37a5a->enter($__internal_ec5a42981c2f236cec0ffa08035f0233d5454327e5647c49ecdb5a2d69e37a5a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "WebProfilerBundle:Collector:router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_ec5a42981c2f236cec0ffa08035f0233d5454327e5647c49ecdb5a2d69e37a5a->leave($__internal_ec5a42981c2f236cec0ffa08035f0233d5454327e5647c49ecdb5a2d69e37a5a_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_94315f83c90ddddbd2a7daf0f0fa3bb2f902cae076cf9adee7ad96c4b9b1e1bd = $this->env->getExtension("native_profiler");
        $__internal_94315f83c90ddddbd2a7daf0f0fa3bb2f902cae076cf9adee7ad96c4b9b1e1bd->enter($__internal_94315f83c90ddddbd2a7daf0f0fa3bb2f902cae076cf9adee7ad96c4b9b1e1bd_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_94315f83c90ddddbd2a7daf0f0fa3bb2f902cae076cf9adee7ad96c4b9b1e1bd->leave($__internal_94315f83c90ddddbd2a7daf0f0fa3bb2f902cae076cf9adee7ad96c4b9b1e1bd_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_21d34265d62452e5a828cd1e374ee633945678b3bebac39c16a272a8ec11321e = $this->env->getExtension("native_profiler");
        $__internal_21d34265d62452e5a828cd1e374ee633945678b3bebac39c16a272a8ec11321e->enter($__internal_21d34265d62452e5a828cd1e374ee633945678b3bebac39c16a272a8ec11321e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_21d34265d62452e5a828cd1e374ee633945678b3bebac39c16a272a8ec11321e->leave($__internal_21d34265d62452e5a828cd1e374ee633945678b3bebac39c16a272a8ec11321e_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_5770e0609c0404659003fca60ac26f59acf4c4c0334fb699cf52d6d03d33142b = $this->env->getExtension("native_profiler");
        $__internal_5770e0609c0404659003fca60ac26f59acf4c4c0334fb699cf52d6d03d33142b->enter($__internal_5770e0609c0404659003fca60ac26f59acf4c4c0334fb699cf52d6d03d33142b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_router", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_5770e0609c0404659003fca60ac26f59acf4c4c0334fb699cf52d6d03d33142b->leave($__internal_5770e0609c0404659003fca60ac26f59acf4c4c0334fb699cf52d6d03d33142b_prof);

    }

    public function getTemplateName()
    {
        return "WebProfilerBundle:Collector:router.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 13,  67 => 12,  56 => 7,  53 => 6,  47 => 5,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@WebProfiler/Profiler/layout.html.twig' %}*/
/* */
/* {% block toolbar %}{% endblock %}*/
/* */
/* {% block menu %}*/
/* <span class="label">*/
/*     <span class="icon">{{ include('@WebProfiler/Icon/router.svg') }}</span>*/
/*     <strong>Routing</strong>*/
/* </span>*/
/* {% endblock %}*/
/* */
/* {% block panel %}*/
/*     {{ render(path('_profiler_router', { token: token })) }}*/
/* {% endblock %}*/
/* */
