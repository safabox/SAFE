<?php

/* @Framework/Form/form_end.html.php */
class __TwigTemplate_ec3c0b389631c6357c8e92fd1f4d4af5bd7a8dc2d580b3d0354e4313cbb97ded extends Twig_Template
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
        $__internal_2981451ea94355826dbcfb643a51c9482d46938f3412ac935e6748d695e1c7f5 = $this->env->getExtension("native_profiler");
        $__internal_2981451ea94355826dbcfb643a51c9482d46938f3412ac935e6748d695e1c7f5->enter($__internal_2981451ea94355826dbcfb643a51c9482d46938f3412ac935e6748d695e1c7f5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/form_end.html.php"));

        // line 1
        echo "<?php if (!isset(\$render_rest) || \$render_rest): ?>
<?php echo \$view['form']->rest(\$form) ?>
<?php endif ?>
</form>
";
        
        $__internal_2981451ea94355826dbcfb643a51c9482d46938f3412ac935e6748d695e1c7f5->leave($__internal_2981451ea94355826dbcfb643a51c9482d46938f3412ac935e6748d695e1c7f5_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/form_end.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <?php if (!isset($render_rest) || $render_rest): ?>*/
/* <?php echo $view['form']->rest($form) ?>*/
/* <?php endif ?>*/
/* </form>*/
/* */
