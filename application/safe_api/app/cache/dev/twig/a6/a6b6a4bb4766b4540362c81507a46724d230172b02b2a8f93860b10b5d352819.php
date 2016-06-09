<?php

/* @Framework/Form/form_errors.html.php */
class __TwigTemplate_ceece67376f96817f27077ae544ef6d42e0e13fbf533562e696343a2c9d9b2da extends Twig_Template
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
        $__internal_616faabc2953a7e40aa3d95c6bf14b1d01b166c01581576659c92c3b9ea82b2a = $this->env->getExtension("native_profiler");
        $__internal_616faabc2953a7e40aa3d95c6bf14b1d01b166c01581576659c92c3b9ea82b2a->enter($__internal_616faabc2953a7e40aa3d95c6bf14b1d01b166c01581576659c92c3b9ea82b2a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Framework/Form/form_errors.html.php"));

        // line 1
        echo "<?php if (count(\$errors) > 0): ?>
    <ul>
        <?php foreach (\$errors as \$error): ?>
            <li><?php echo \$error->getMessage() ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif ?>
";
        
        $__internal_616faabc2953a7e40aa3d95c6bf14b1d01b166c01581576659c92c3b9ea82b2a->leave($__internal_616faabc2953a7e40aa3d95c6bf14b1d01b166c01581576659c92c3b9ea82b2a_prof);

    }

    public function getTemplateName()
    {
        return "@Framework/Form/form_errors.html.php";
    }

    public function getDebugInfo()
    {
        return array (  22 => 1,);
    }
}
/* <?php if (count($errors) > 0): ?>*/
/*     <ul>*/
/*         <?php foreach ($errors as $error): ?>*/
/*             <li><?php echo $error->getMessage() ?></li>*/
/*         <?php endforeach; ?>*/
/*     </ul>*/
/* <?php endif ?>*/
/* */
