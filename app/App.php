<?php

    namespace Tivet\Banner;

    use Intervention\Image\Gd\Font;
    use Intervention\Image\ImageManager;
    use Tivet\Banner\Utils\Text as Text;

    class App
    {
        public function __construct()
        {
            echo $this->init();
        }


        public function init()
        {
            if (conf('banner.cache') === true) {
                if (Cache::has("image." . Request::getValidIpAddress())) {
                    return $this->responseCached();
                }
            }

            $template = new Template(conf('banner.template'));

            $manager = new ImageManager(['driver' => conf('image.driver')]);

            $background = $manager->make($template->getBackgroundLocation());

            foreach ($template->getConfig() as $templateConfigKey => $temlateConfigValue) {
                if ($templateConfigKey === 'text') {

                    foreach ($temlateConfigValue as $templateConfigText) {

                        $background->text($templateConfigText['value'], $templateConfigText['x'], $templateConfigText['y'], function ($font) use ($templateConfigText) {
                            /** @var $font Font */

                            $font->file($templateConfigText['font'] ?? null);
                            $font->color(array_merge(Text::hex2rgb($templateConfigText['color']), [$templateConfigText['opacity'] ?? 1]) ?? '#FFFFFF');
                            $font->size($templateConfigText['size'] ?? null);
                            $font->align($templateConfigText['align'] ?? 'left');
                            $font->valign($templateConfigText['valign'] ?? 'top');
                        });
                    }
                }
            }

            ob_start();
            echo $background->response('jpg', 100);
            $cacheData = ob_get_contents();
            ob_end_clean();

            Cache::set("image." . Request::getValidIpAddress(), $cacheData);

            return $cacheData;
        }


        public function responseCached()
        {
            $manager = new ImageManager(['driver' => conf('image.driver')]);

            $background = $manager->make(Cache::get("image." . Request::getValidIpAddress()));

            return $background->response('jpg', 100);
        }
    }