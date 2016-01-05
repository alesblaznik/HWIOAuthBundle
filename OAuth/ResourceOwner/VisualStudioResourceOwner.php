<?php
/**
 * File containing VisualStudioResourceOwner class
 *
 * @author    Aleš Blaznik <ales.blaznik@dlabs.si>
 * @copyright 2016 DLabs (http://www.dlabs.si)
 */

namespace HWI\Bundle\OAuthBundle\OAuth\ResourceOwner;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class VisualStudioResourceOwner
 *
 * @package HWI\Bundle\OAuthBundle\OAuth\ResourceOwner
 */
class VisualStudioResourceOwner extends GenericOAuth2ResourceOwner
{
    protected $paths = [
        'identifier'     => 'id',
        'nickname'       => 'emailAddress',
        'realname'       => 'displayName',
    ];

    protected function configureOptions(OptionsResolverInterface $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'authorization_url' => 'https://app.vssps.visualstudio.com/oauth2/authorize',
            'access_token_url'  => 'https://app.vssps.visualstudio.com/oauth2/token',
            'infos_url'         => 'https://app.vssps.visualstudio.com/_apis/profile/profiles/me?api-version=1.0',
            'attr_name'         => 'assertion',
        ]);
    }
}
