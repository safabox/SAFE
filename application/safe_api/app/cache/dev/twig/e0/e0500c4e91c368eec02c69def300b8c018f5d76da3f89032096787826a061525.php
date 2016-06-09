<?php

/* @Framework/Form/form_rest.html.php */
class __TwigTemplate_71350cc504f85695ab6d52906cc9e78c079b776dd26cdba438c8ac1f8f33d358 extends Twig_Template
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
        $__internal_7f8c80948ffa3077bc234eca4ef3f4250abc06ab8079e131afd50ad7d866e0eb = $this->env->getExtension("native_profiler");
        $__internal_7f8c80948ffa3077bc234eca4ef3f4250abc06ab8079e131afd50ad7d866e0eb->enter($__internal_7f8c80948ffa3077bc234eca4ef3f4250abc06ab8079e131afd50ad7d866e0eb_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/form_rest.html.php"));

        // line 1
        echo "<?php foreach (\$form as \$child): ?>
    <?php if (!\$child->isRendered()): ?>
        <?php echo \$view['form']->row(\$child) ?>
    <?php endif; ?>
<?php endforeach; ?>
";
        
        $__internal_7f8c80948ffa3077bc234eca4ef3f4250abc06ab8079e131afd50ad7d866e0eb->leave($__internal_7f8c80948ffa3077bc234eca4ef3f4250abc06ab8079e131afd50ad7d866e0eb_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/form_rest.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <?php foreach ($form as $child): ?>*/
/*     <?php if (!$child->isRendered()): ?>*/
/*         <?php echo $view['form']->row($child) ?>*/
/*     <?php endif; ?>*/
/* <?php endforeach; ?>*/
/* */
