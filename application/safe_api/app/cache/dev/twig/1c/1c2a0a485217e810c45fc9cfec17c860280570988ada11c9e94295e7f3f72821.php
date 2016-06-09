<?php

/* TwigBundle:Exception:error.atom.twig */
class __TwigTemplate_d1efc3c54bf9e4ec6d3229c439d95d3619e65a9ae4a8f173b91b870208fd642c extends Twig_Template
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
        $__internal_578c4b3e41358b487e66d7ebf18bf970aa7d7353973a38ac744148d634a657ac = $this->env->getExtension("native_profiler");
        $__internal_578c4b3e41358b487e66d7ebf18bf970aa7d7353973a38ac744148d634a657ac->enter($__internal_578c4b3e41358b487e66d7ebf18bf970aa7d7353973a38ac744148d634a657ac_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:error.atom.twig"));

        // line 1
        $this->loadTemplate("@Twig/Exception/error.xml.twig", "TwigBundle:Exception:error.atom.twig", 1)->display($context);
        
        $__internal_578c4b3e41358b487e66d7ebf18bf970aa7d7353973a38ac744148d634a657ac->leave($__internal_578c4b3e41358b487e66d7ebf18bf970aa7d7353973a38ac744148d634a657ac_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:error.atom.twig";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* {% include '@Twig/Exception/error.xml.twig' %}*/
/* */
