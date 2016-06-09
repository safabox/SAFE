<?php

/* @WebProfiler/Collector/router.html.twig */
class __TwigTemplate_f5fcadddb5adb7f0145d3ef165eb459f8164671dae9fea5defb52ec985071254 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/router.html.twig", 1);
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
        $__internal_05e65544f65d7aff34bd3d74803dab934829762c4a3f0e1f461b41b309428458 = $this->env->getExtension("native_profiler");
        $__internal_05e65544f65d7aff34bd3d74803dab934829762c4a3f0e1f461b41b309428458->enter($__internal_05e65544f65d7aff34bd3d74803dab934829762c4a3f0e1f461b41b309428458_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_05e65544f65d7aff34bd3d74803dab934829762c4a3f0e1f461b41b309428458->leave($__internal_05e65544f65d7aff34bd3d74803dab934829762c4a3f0e1f461b41b309428458_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_ab85dc0958dc5ed2e58f3b83109cb057e8bc5688b319b34890d887a40159752e = $this->env->getExtension("native_profiler");
        $__internal_ab85dc0958dc5ed2e58f3b83109cb057e8bc5688b319b34890d887a40159752e->enter($__internal_ab85dc0958dc5ed2e58f3b83109cb057e8bc5688b319b34890d887a40159752e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_ab85dc0958dc5ed2e58f3b83109cb057e8bc5688b319b34890d887a40159752e->leave($__internal_ab85dc0958dc5ed2e58f3b83109cb057e8bc5688b319b34890d887a40159752e_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_406f1621af09c8596288816a96a51ebcce3bdcc9d2574594751a444377de34c5 = $this->env->getExtension("native_profiler");
        $__internal_406f1621af09c8596288816a96a51ebcce3bdcc9d2574594751a444377de34c5->enter($__internal_406f1621af09c8596288816a96a51ebcce3bdcc9d2574594751a444377de34c5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_406f1621af09c8596288816a96a51ebcce3bdcc9d2574594751a444377de34c5->leave($__internal_406f1621af09c8596288816a96a51ebcce3bdcc9d2574594751a444377de34c5_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_73d50c0cae155689e251c167f6ea7f271f74719921941a684972ce3cec2425e4 = $this->env->getExtension("native_profiler");
        $__internal_73d50c0cae155689e251c167f6ea7f271f74719921941a684972ce3cec2425e4->enter($__internal_73d50c0cae155689e251c167f6ea7f271f74719921941a684972ce3cec2425e4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_router", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_73d50c0cae155689e251c167f6ea7f271f74719921941a684972ce3cec2425e4->leave($__internal_73d50c0cae155689e251c167f6ea7f271f74719921941a684972ce3cec2425e4_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/router.html.twig";
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
