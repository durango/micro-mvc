<?php

/* layout.html */
class __TwigTemplate_4598ffc8e3aeb8a82408ea92494dbe1b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<h1>Welcome!</h1>
";
        // line 2
        if (isset($context["before"])) { $_before_ = $context["before"]; } else { $_before_ = null; }
        if (($_before_ != "")) {
            // line 3
            echo "<strong>Before Message:</strong> ";
            if (isset($context["before"])) { $_before_ = $context["before"]; } else { $_before_ = null; }
            echo twig_escape_filter($this->env, $_before_, "html", null, true);
            echo "<br><br>
";
        }
        // line 5
        $this->displayBlock('content', $context, $blocks);
    }

    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "layout.html";
    }

    public function isTraitable()
    {
        return false;
    }
}
