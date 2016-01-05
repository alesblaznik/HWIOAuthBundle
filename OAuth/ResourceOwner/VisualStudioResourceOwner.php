<?php
/**
 * File containing VisualStudioResourceOwner class
 *
 * @author    Aleš Blaznik <ales.blaznik@dlabs.si>
 * @copyright 2016 DLabs (http://www.dlabs.si)
 */

namespace HWI\Bundle\OAuthBundle\OAuth\ResourceOwner;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class VisualStudioResourceOwner
 *
 * @package HWI\Bundle\OAuthBundle\OAuth\ResourceOwner
 */
class VisualStudioResourceOwner extends GenericOAuth2ResourceOwner
{
    /**
     * {@inheritDoc}
     */
    protected $paths = [
        'identifier'     => 'id',
        'nickname'       => 'emailAddress',
        'realname'       => 'displayName',
    ];

    /**
     * {@inheritDoc}
     */
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

    /**
     * {@inheritDoc}
     */
    public function getAccessToken(Request $request, $redirectUri, array $extraParameters = array())
    {
        $parameters = array_merge(array(
            'assertion'             => $request->query->get('code'),
            'grant_type'            => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
            'client_assertion'      => $this->options['client_secret'],
            'redirect_uri'          => $redirectUri,
        ), $extraParameters);

        $response = $this->doGetTokenRequest($this->options['access_token_url'], $parameters);
        $response = $this->getResponseContent($response);

        $this->validateResponseContent($response);

        return $response;
    }
}