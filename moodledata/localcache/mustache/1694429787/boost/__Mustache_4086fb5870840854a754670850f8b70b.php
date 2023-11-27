<?php

class __Mustache_4086fb5870840854a754670850f8b70b extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<nav class="list-group" aria-label="';
        $value = $this->resolveValue($context->find('firstcollectionlabel'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '    <ul>
';
        $value = $context->find('flatnavigation');
        $buffer .= $this->section9eb84a102032fc7185c162f74d4b8cbe($context, $indent, $value);
        $buffer .= $indent . '    </ul>
';
        $buffer .= $indent . '</nav>
';

        return $buffer;
    }

    private function sectionC91974b2eb1dddc388f46ddf576adcfa(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            </ul>
            </nav>
            <nav class="list-group mt-1" aria-label="{{get_collectionlabel}}">
            <ul>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            </ul>
';
                $buffer .= $indent . '            </nav>
';
                $buffer .= $indent . '            <nav class="list-group mt-1" aria-label="';
                $value = $this->resolveValue($context->find('get_collectionlabel'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">
';
                $buffer .= $indent . '            <ul>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5749c750acb0d7477dd5257d00cc6d53(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'active';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'active';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5e96ec75439305fc88c78e77946e47bb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{.}} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2233087813f2f0dc85c21e6f8a0b28de(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'data-parent-key="{{.}}"';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'data-parent-key="';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0c636b8d211c8807beb0b37869ad3b26(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{{icon.pix}}}, {{{icon.component}}}, {{{icon.alt}}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->findDot('icon.pix'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= ', ';
                $value = $this->resolveValue($context->findDot('icon.component'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= ', ';
                $value = $this->resolveValue($context->findDot('icon.alt'), $context);
                $buffer .= ($value === null ? '' : $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1308b5002978dce628a34c18bb6c6ade(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                                <span class="media-left">
                                    {{#pix}}{{{icon.pix}}}, {{{icon.component}}}, {{{icon.alt}}}{{/pix}}
                                </span>
                            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                                <span class="media-left">
';
                $buffer .= $indent . '                                    ';
                $value = $context->find('pix');
                $buffer .= $this->section0c636b8d211c8807beb0b37869ad3b26($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                                </span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE262a41669da4e6e3b97fcdc38c27010(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'font-weight-bold';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'font-weight-bold';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0551039087f4d4046d16f6b887f8a60e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <li>
                <a class="list-group-item list-group-item-action {{#isactive}}active{{/isactive}} {{#classes}}{{.}} {{/classes}}" href="{{{action}}}" data-key="{{key}}" data-isexpandable="{{isexpandable}}" data-indent="{{get_indent}}" data-showdivider="{{showdivider}}" data-type="{{type}}" data-nodetype="{{nodetype}}" data-collapse="{{collapse}}" data-forceopen="{{forceopen}}" data-isactive="{{isactive}}" data-hidden="{{hidden}}" data-preceedwithhr="{{preceedwithhr}}" {{#parent.key}}data-parent-key="{{.}}"{{/parent.key}}>
                    <div class="ml-{{get_indent}}">
                        <div class="media">
                            {{#icon.pix}}
                                <span class="media-left">
                                    {{#pix}}{{{icon.pix}}}, {{{icon.component}}}, {{{icon.alt}}}{{/pix}}
                                </span>
                            {{/icon.pix}}
                            <span class="media-body {{#isactive}}font-weight-bold{{/isactive}}">{{{text}}}</span>
                        </div>
                    </div>
                </a>
            </li>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <li>
';
                $buffer .= $indent . '                <a class="list-group-item list-group-item-action ';
                $value = $context->find('isactive');
                $buffer .= $this->section5749c750acb0d7477dd5257d00cc6d53($context, $indent, $value);
                $buffer .= ' ';
                $value = $context->find('classes');
                $buffer .= $this->section5e96ec75439305fc88c78e77946e47bb($context, $indent, $value);
                $buffer .= '" href="';
                $value = $this->resolveValue($context->find('action'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '" data-key="';
                $value = $this->resolveValue($context->find('key'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" data-isexpandable="';
                $value = $this->resolveValue($context->find('isexpandable'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" data-indent="';
                $value = $this->resolveValue($context->find('get_indent'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" data-showdivider="';
                $value = $this->resolveValue($context->find('showdivider'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" data-type="';
                $value = $this->resolveValue($context->find('type'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" data-nodetype="';
                $value = $this->resolveValue($context->find('nodetype'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" data-collapse="';
                $value = $this->resolveValue($context->find('collapse'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" data-forceopen="';
                $value = $this->resolveValue($context->find('forceopen'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" data-isactive="';
                $value = $this->resolveValue($context->find('isactive'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" data-hidden="';
                $value = $this->resolveValue($context->find('hidden'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" data-preceedwithhr="';
                $value = $this->resolveValue($context->find('preceedwithhr'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" ';
                $value = $context->findDot('parent.key');
                $buffer .= $this->section2233087813f2f0dc85c21e6f8a0b28de($context, $indent, $value);
                $buffer .= '>
';
                $buffer .= $indent . '                    <div class="ml-';
                $value = $this->resolveValue($context->find('get_indent'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">
';
                $buffer .= $indent . '                        <div class="media">
';
                $value = $context->findDot('icon.pix');
                $buffer .= $this->section1308b5002978dce628a34c18bb6c6ade($context, $indent, $value);
                $buffer .= $indent . '                            <span class="media-body ';
                $value = $context->find('isactive');
                $buffer .= $this->sectionE262a41669da4e6e3b97fcdc38c27010($context, $indent, $value);
                $buffer .= '">';
                $value = $this->resolveValue($context->find('text'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '</span>
';
                $buffer .= $indent . '                        </div>
';
                $buffer .= $indent . '                    </div>
';
                $buffer .= $indent . '                </a>
';
                $buffer .= $indent . '            </li>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9eb84a102032fc7185c162f74d4b8cbe(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{#showdivider}}
            </ul>
            </nav>
            <nav class="list-group mt-1" aria-label="{{get_collectionlabel}}">
            <ul>
        {{/showdivider}}
        {{#action}}
            <li>
                <a class="list-group-item list-group-item-action {{#isactive}}active{{/isactive}} {{#classes}}{{.}} {{/classes}}" href="{{{action}}}" data-key="{{key}}" data-isexpandable="{{isexpandable}}" data-indent="{{get_indent}}" data-showdivider="{{showdivider}}" data-type="{{type}}" data-nodetype="{{nodetype}}" data-collapse="{{collapse}}" data-forceopen="{{forceopen}}" data-isactive="{{isactive}}" data-hidden="{{hidden}}" data-preceedwithhr="{{preceedwithhr}}" {{#parent.key}}data-parent-key="{{.}}"{{/parent.key}}>
                    <div class="ml-{{get_indent}}">
                        <div class="media">
                            {{#icon.pix}}
                                <span class="media-left">
                                    {{#pix}}{{{icon.pix}}}, {{{icon.component}}}, {{{icon.alt}}}{{/pix}}
                                </span>
                            {{/icon.pix}}
                            <span class="media-body {{#isactive}}font-weight-bold{{/isactive}}">{{{text}}}</span>
                        </div>
                    </div>
                </a>
            </li>
        {{/action}}
        {{^action}}
            <li>
                <div class="list-group-item {{#classes}}{{.}} {{/classes}}" data-key="{{key}}" data-isexpandable="{{isexpandable}}" data-indent="{{get_indent}}" data-showdivider="{{showdivider}}" data-type="{{type}}" data-nodetype="{{nodetype}}" data-collapse="{{collapse}}" data-forceopen="{{forceopen}}" data-isactive="{{isactive}}" data-hidden="{{hidden}}" data-preceedwithhr="{{preceedwithhr}}" {{#parent.key}}data-parent-key="{{.}}"{{/parent.key}}>
                    <div class="ml-{{get_indent}}">
                        <div class="media">
                            {{#icon.pix}}
                                <span class="media-left">
                                    {{#pix}}{{{icon.pix}}}, {{{icon.component}}}, {{{icon.alt}}}{{/pix}}
                                </span>
                            {{/icon.pix}}
                            <span class="media-body">{{{text}}}</span>
                        </div>
                    </div>
                </div>
            </li>
        {{/action}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('showdivider');
                $buffer .= $this->sectionC91974b2eb1dddc388f46ddf576adcfa($context, $indent, $value);
                $value = $context->find('action');
                $buffer .= $this->section0551039087f4d4046d16f6b887f8a60e($context, $indent, $value);
                $value = $context->find('action');
                if (empty($value)) {
                    
                    $buffer .= $indent . '            <li>
';
                    $buffer .= $indent . '                <div class="list-group-item ';
                    $value = $context->find('classes');
                    $buffer .= $this->section5e96ec75439305fc88c78e77946e47bb($context, $indent, $value);
                    $buffer .= '" data-key="';
                    $value = $this->resolveValue($context->find('key'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" data-isexpandable="';
                    $value = $this->resolveValue($context->find('isexpandable'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" data-indent="';
                    $value = $this->resolveValue($context->find('get_indent'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" data-showdivider="';
                    $value = $this->resolveValue($context->find('showdivider'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" data-type="';
                    $value = $this->resolveValue($context->find('type'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" data-nodetype="';
                    $value = $this->resolveValue($context->find('nodetype'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" data-collapse="';
                    $value = $this->resolveValue($context->find('collapse'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" data-forceopen="';
                    $value = $this->resolveValue($context->find('forceopen'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" data-isactive="';
                    $value = $this->resolveValue($context->find('isactive'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" data-hidden="';
                    $value = $this->resolveValue($context->find('hidden'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" data-preceedwithhr="';
                    $value = $this->resolveValue($context->find('preceedwithhr'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" ';
                    $value = $context->findDot('parent.key');
                    $buffer .= $this->section2233087813f2f0dc85c21e6f8a0b28de($context, $indent, $value);
                    $buffer .= '>
';
                    $buffer .= $indent . '                    <div class="ml-';
                    $value = $this->resolveValue($context->find('get_indent'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '">
';
                    $buffer .= $indent . '                        <div class="media">
';
                    $value = $context->findDot('icon.pix');
                    $buffer .= $this->section1308b5002978dce628a34c18bb6c6ade($context, $indent, $value);
                    $buffer .= $indent . '                            <span class="media-body">';
                    $value = $this->resolveValue($context->find('text'), $context);
                    $buffer .= ($value === null ? '' : $value);
                    $buffer .= '</span>
';
                    $buffer .= $indent . '                        </div>
';
                    $buffer .= $indent . '                    </div>
';
                    $buffer .= $indent . '                </div>
';
                    $buffer .= $indent . '            </li>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
