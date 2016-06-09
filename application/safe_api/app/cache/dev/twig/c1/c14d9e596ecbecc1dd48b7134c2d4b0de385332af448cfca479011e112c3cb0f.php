<?php

/* @Framework/Form/collection_widget.html.php */
class __TwigTemplate_45f5196ef4e096e59b1ffb9a4ea93f96544ceadf53bbca0284c5b7c571cfd210 extends Twig_Template
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
        $__internal_3c400ffb49b0b5fbe3325f7432421387454c5967d8d9684f16df981ce6c3439a = $this->env->getExtension("native_profiler");
        $__internal_3c400ffb49b0b5fbe3325f7432421387454c5967d8d9684f16df981ce6c3439a->enter($__internal_3c400ffb49b0b5fbe3325f7432421387454c5967d8d9684f16df981ce6c3439a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/collection_widget.html.php"));

        // line 1
        echo "<?php if (isset(\$prototype)): ?>
    <?php \$attr['data-prototype'] = \$view->escape(\$view['form']->row(\$prototype)) ?>
<?php endif ?>
<?php echo \$view['form']->widget(\$form, array('attr' => \$attr)) ?>
";
        
        $__internal_3c400ffb49b0b5fbe3325f7432421387454c5967d8d9684f16df981ce6c3439a->leave($__internal_3c400ffb49b0b5fbe3325f7432421387454c5967d8d9684f16df981ce6c3439a_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/collection_widget.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <?php if (isset($prototype)): ?>*/
/*     <?php $attr['data-prototype'] = $view->escape($view['form']->row($prototype)) ?>*/
/* <?php endif ?>*/
/* <?php echo $view['form']->widget($form, array('attr' => $attr)) ?>*/
/* */
