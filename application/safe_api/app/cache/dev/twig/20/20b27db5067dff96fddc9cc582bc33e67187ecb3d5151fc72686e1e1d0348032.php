<?php

/* WebProfilerBundle:Collector:exception.html.twig */
class __TwigTemplate_0db480bd83cd8af878318a8cc68b4fab6a1141f35bda711fcb1e7f3cd7194ed8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "WebProfilerBundle:Collector:exception.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
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
        $__internal_111f12e542e3a7e928b72392d5f1fec3b51ace4fe7a81fb1ef2c574823719828 = $this->env->getExtension("native_profiler");
        $__internal_111f12e542e3a7e928b72392d5f1fec3b51ace4fe7a81fb1ef2c574823719828->enter($__internal_111f12e542e3a7e928b72392d5f1fec3b51ace4fe7a81fb1ef2c574823719828_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "WebProfilerBundle:Collector:exception.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_111f12e542e3a7e928b72392d5f1fec3b51ace4fe7a81fb1ef2c574823719828->leave($__internal_111f12e542e3a7e928b72392d5f1fec3b51ace4fe7a81fb1ef2c574823719828_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_7d90b7fd2a3010b718be9293795eb1f4995c227ecd22d07e26b29eb359c09a6d = $this->env->getExtension("native_profiler");
        $__internal_7d90b7fd2a3010b718be9293795eb1f4995c227ecd22d07e26b29eb359c09a6d->enter($__internal_7d90b7fd2a3010b718be9293795eb1f4995c227ecd22d07e26b29eb359c09a6d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    ";
        if ($this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "hasexception", array())) {
            // line 5
            echo "        <style>
            ";
            // line 6
            echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_exception_css", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
            echo "
        </style>
    ";
        }
        // line 9
        echo "    ";
        $this->displayParentBlock("head", $context, $blocks);
        echo "
";
        
        $__internal_7d90b7fd2a3010b718be9293795eb1f4995c227ecd22d07e26b29eb359c09a6d->leave($__internal_7d90b7fd2a3010b718be9293795eb1f4995c227ecd22d07e26b29eb359c09a6d_prof);

    }

    // line 12
    public function block_menu($context, array $blocks = array())
    {
        $__internal_56749e50cc449c6e4b2ee214d7bdbb3456078f0db30f40eee994a0166e13b17a = $this->env->getExtension("native_profiler");
        $__internal_56749e50cc449c6e4b2ee214d7bdbb3456078f0db30f40eee994a0166e13b17a->enter($__internal_56749e50cc449c6e4b2ee214d7bdbb3456078f0db30f40eee994a0166e13b17a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 13
        echo "    <span class=\"label ";
        echo (($this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "hasexception", array())) ? ("label-status-error") : ("disabled"));
        echo "\">
        <span class=\"icon\">";
        // line 14
        echo twig_include($this->env, $context, "@WebProfiler/Icon/exception.svg");
        echo "</span>
        <strong>Exception</strong>
        ";
        // line 16
        if ($this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "hasexception", array())) {
            // line 17
            echo "            <span class=\"count\">
                <span>1</span>
            </span>
        ";
        }
        // line 21
        echo "    </span>
";
        
        $__internal_56749e50cc449c6e4b2ee214d7bdbb3456078f0db30f40eee994a0166e13b17a->leave($__internal_56749e50cc449c6e4b2ee214d7bdbb3456078f0db30f40eee994a0166e13b17a_prof);

    }

    // line 24
    public function block_panel($context, array $blocks = array())
    {
        $__internal_568768042d52494856075671a0b9e48cd7297bbaf75def7750fc44b6610a9dec = $this->env->getExtension("native_profiler");
        $__internal_568768042d52494856075671a0b9e48cd7297bbaf75def7750fc44b6610a9dec->enter($__internal_568768042d52494856075671a0b9e48cd7297bbaf75def7750fc44b6610a9dec_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 25
        echo "    <h2>Exceptions</h2>

    ";
        // line 27
        if ( !$this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "hasexception", array())) {
            // line 28
            echo "        <div class=\"empty\">
            <p>No exception was thrown and caught during the request.</p>
        </div>
    ";
        } else {
            // line 32
            echo "        <div class=\"sf-reset\">
            ";
            // line 33
            echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_exception", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
            echo "
        </div>
    ";
        }
        
        $__internal_568768042d52494856075671a0b9e48cd7297bbaf75def7750fc44b6610a9dec->leave($__internal_568768042d52494856075671a0b9e48cd7297bbaf75def7750fc44b6610a9dec_prof);

    }

    public function getTemplateName()
    {
        return "WebProfilerBundle:Collector:exception.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  117 => 33,  114 => 32,  108 => 28,  106 => 27,  102 => 25,  96 => 24,  88 => 21,  82 => 17,  80 => 16,  75 => 14,  70 => 13,  64 => 12,  54 => 9,  48 => 6,  45 => 5,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@WebProfiler/Profiler/layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     {% if collector.hasexception %}*/
/*         <style>*/
/*             {{ render(path('_profiler_exception_css', { token: token })) }}*/
/*         </style>*/
/*     {% endif %}*/
/*     {{ parent() }}*/
/* {% endblock %}*/
/* */
/* {% block menu %}*/
/*     <span class="label {{ collector.hasexception ? 'label-status-error' : 'disabled' }}">*/
/*         <span class="icon">{{ include('@WebProfiler/Icon/exception.svg') }}</span>*/
/*         <strong>Exception</strong>*/
/*         {% if collector.hasexception %}*/
/*             <span class="count">*/
/*                 <span>1</span>*/
/*             </span>*/
/*         {% endif %}*/
/*     </span>*/
/* {% endblock %}*/
/* */
/* {% block panel %}*/
/*     <h2>Exceptions</h2>*/
/* */
/*     {% if not collector.hasexception %}*/
/*         <div class="empty">*/
/*             <p>No exception was thrown and caught during the request.</p>*/
/*         </div>*/
/*     {% else %}*/
/*         <div class="sf-reset">*/
/*             {{ render(path('_profiler_exception', { token: token })) }}*/
/*         </div>*/
/*     {% endif %}*/
/* {% endblock %}*/
/* */
