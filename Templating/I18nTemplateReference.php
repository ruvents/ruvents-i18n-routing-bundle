<?php

namespace Ruwork\RoutingBundle\Templating;

use Symfony\Component\HttpFoundation\Request;

class I18nTemplateReference
{
    /**
     * @var TemplateExportableReference
     */
    private $template;

    /**
     * @var string[]
     */
    private $locales;

    /**
     * @param TemplateExportableReference $template
     * @param array                       $locales
     */
    public function __construct(TemplateExportableReference $template, array $locales = [])
    {
        $this->template = $template;
        $this->locales = $locales;
    }

    /**
     * @param array $data
     * @return I18nTemplateReference
     */
    public static function __set_state(array $data)
    {
        return new static($data['template'], $data['locales']);
    }

    /**
     * @return string[]
     */
    public function getLocales()
    {
        return array_unique($this->locales);
    }

    /**
     * @param string $locale
     * @return bool
     */
    public function hasLocale($locale)
    {
        return in_array($locale, $this->locales, true);
    }

    /**
     * @param string $locale
     * @return $this
     */
    public function addLocale($locale)
    {
        $this->locales[] = $locale;

        return $this;
    }

    /**
     * @param Request $request
     * @return TemplateExportableReference
     */
    public function resolveLocale(Request $request)
    {
        $template = clone $this->template;

        if ($this->hasLocale($request->getLocale())) {
            $template->set('name', $template->get('name').'.'.$request->getLocale());
        }

        return $template;
    }
}