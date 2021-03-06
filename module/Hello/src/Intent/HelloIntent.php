<?php
/**
 * Skeleton application to build voice applications for Amazon Alexa with phlexa, PHP and Mezzio
 *
 * @author     Ralf Eggert <ralf@travello.audio>
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/phoice/phlexa-mezzio-skeleton
 * @link       https://www.phoice.tech/
 * @link       https://www.travello.audio/
 */

namespace Hello\Intent;

use Hello\TextHelper\HelloTextHelper;
use Phlexa\Content\BodyContainer;
use Phlexa\Content\ImageContainer;
use Phlexa\Intent\AbstractIntent;
use Phlexa\Response\AlexaResponse;
use Phlexa\Response\Directives\Alexa\Presentation\APL\Document\APL;
use Phlexa\Response\Directives\Display\RenderTemplate;

/**
 * Class HelloIntent
 *
 * @package Hello\Intent
 * @method HelloTextHelper getTextHelper()
 */
class HelloIntent extends AbstractIntent
{
    const NAME = 'HelloIntent';

    /**
     * @return AlexaResponse
     */
    public function handle(): AlexaResponse
    {
        $sessionContainer = $this->getAlexaResponse()->getSessionContainer();

        $count = $sessionContainer->getAttribute('count') + 1;

        $sessionContainer->setAttribute('count', $count);

        $message = $this->getTextHelper()->getHelloMessage() . ' (' . $count . ')';

        $content = [
            'output_speech'      => $message,
            'reprompt_speech'    => null,
            'token'              => 'help',
            'display_template'   => RenderTemplate::TYPE_BODY_TEMPLATE_6,
            'apl_document'       => APL::createFromString(
                $this->getSkillConfiguration()->getAplDocuments()['normal-body']
            ),
            'display_title'      => $this->getTextHelper()->getHelloTitle(),
            'display_large_text' => $message,
            'logo_icon'          => $this->getSkillConfiguration()->getSmallIconImage(),
            'hint_text'          => $this->getTextHelper()->getHintText(),
            'image'              => new ImageContainer(
                [
                    'image_title'                  => $this->getTextHelper()->getHelloTitle(),
                    'small_front_image'            => $this->getSkillConfiguration()->getSmallFrontImage(),
                    'large_front_image'            => $this->getSkillConfiguration()->getLargeFrontImage(),
                    'round_background_image'       => $this->getSkillConfiguration()->getRoundBackgroundImage(),
                    'small_background_image'       => $this->getSkillConfiguration()->getSmallBackgroundImage(),
                    'medium_background_image'      => $this->getSkillConfiguration()->getMediumBackgroundImage(),
                    'large_background_image'       => $this->getSkillConfiguration()->getLargeBackgroundImage(),
                    'extra_large_background_image' => $this->getSkillConfiguration()->getExtraLargeBackgroundImage(),
                ]
            ),
            'card'               => true,
            'display'            => true,
            'apl'                => true,
        ];

        $this->renderBodyContainer(new BodyContainer($content));

        return $this->getAlexaResponse();
    }
}
