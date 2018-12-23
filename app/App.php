<?php

    namespace Tivet\Banner;

    use GImage\Canvas;
    use GImage\Text;
    use GImage\Image;
    use Tivet\Banner\Utils\Text as TextUtil;

    class App
    {
        /**
         * @return Image
         * @throws \Exception
         */
        public function init()
        {
            if (Cache::has("image." . Request::getValidIpAddress())) {
                return $this->responseCached();
            }

            $template = new Template(conf('banner.template'));

            $background = new Image();
            $background->load($template->getBackgroundLocation())->toPNG();

            $canvas = new Canvas($background);

            foreach ($template->getConfig() as $templateConfigKey => $temlateConfigValue) {
                if ($templateConfigKey === 'text') {

                    foreach ($temlateConfigValue as $templateConfigText) {
                        $text = new Text();

                        foreach ($templateConfigText as $textItemKey => $textItemKeyValue) {

                            if (!empty($textItemKeyValue)) {

                                if ($textItemKey === 'value') {
                                    call_user_func_array([$text, 'setContent'], [TextUtil::properText($textItemKeyValue)]);
                                }

                                if ($textItemKey === 'size') {
                                    call_user_func_array([$text, 'setSize'], [$textItemKeyValue]);
                                }

                                if ($textItemKey === 'font') {
                                    call_user_func_array([$text, 'setFontface'], [$textItemKeyValue]);
                                }

                                if ($textItemKey === 'color') {
                                    call_user_func_array([$text, 'setColor'], TextUtil::hex2rgb($textItemKeyValue));
                                }

                                if ($textItemKey === 'opacity') {
                                    call_user_func_array([$text, 'setOpacity'], [$textItemKeyValue]);
                                }
                                if ($textItemKey === 'align') {
                                    call_user_func_array([$text, 'setAlign'], [$textItemKeyValue]);
                                }

                                if ($textItemKey === 'valign') {
                                    call_user_func_array([$text, 'setValign'], [$textItemKeyValue]);
                                }

                                if ($textItemKey === 'width') {
                                    call_user_func_array([$text, 'setWidth'], [$textItemKeyValue]);
                                }
                                if ($textItemKey === 'height') {
                                    call_user_func_array([$text, 'setHeight'], [$textItemKeyValue]);
                                }
                                if ($textItemKey === 'line_height') {
                                    call_user_func_array([$text, 'setLineHeight'], [$textItemKeyValue]);
                                }
                                if ($textItemKey === 'x') {
                                    call_user_func_array([$text, 'setLeft'], [$textItemKeyValue]);
                                }

                                if ($textItemKey === 'y') {
                                    call_user_func_array([$text, 'setTop'], [$textItemKeyValue]);
                                }
                            }
                        }

                        $canvas->append([$text]);
                    }
                }
            }

            $canvas->draw()->toPNG();

            ob_start();
            $canvas->output();
            $cacheData = ob_get_contents();
            ob_end_clean();

            echo $cacheData;
            Cache::set("image." . Request::getValidIpAddress(), $cacheData);
        }


        public function responseCached()
        {
            return (new Image())->load(Cache::get("image." . Request::getValidIpAddress()))->output();
        }
    }