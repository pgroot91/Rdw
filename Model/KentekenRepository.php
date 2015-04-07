<?php
/*
 * This file is part of the nettob component rdw package.
 *
 * (c) Nico Borghuis <nico@nicoborghuis.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Nettob\Component\Rdw\Model;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\RequestException;
use Guzzle\Stream\Stream;
use Nettob\Component\Rdw\Model\Kenteken;

/**
 * Kenteken Repository
 *
 * @package Nettob\Component\Rdw\Model
 * @author Nico Borghuis <nico@nicoborghuis.nl>
 */
class KentekenRepository
{
    /**
     * @var string
     */
    CONST TYPE_EQ = 'eq';

    /**
     * @var string
     */
    CONST TYPE_GT = 'gt';

    /**
     * @var string
     */
    CONST TYPE_GE = 'ge';

    /**
     * @var string
     */
    CONST TYPE_NE = 'ne';

    /**
     * @var string
     */
    CONST TYPE_LT = 'lt';

    /**
     * @var string
     */
    CONST TYPE_LE = 'le';

    /**
     * @var string
     */
    private $apiUrl = "https://api.datamarket.azure.com/opendata.rdw/VRTG.Open.Data/v1/KENT_VRTG_O_DAT";

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $contentType = 'json';

    /**
     * @var \Guzzle\Http\Client
     */
    private $client;

    /**
     * @param string $apiKey
     * @param string $contentType
     */
    public function __construct($apiKey, $contentType = 'json'){
        $this->apiKey = $apiKey;
        $this->contentType = $contentType;
        $this->client = new Client(
            array(
                'defaults' => array(
                    'auth'    => array($this->apiKey, $this->apiKey)
                )
            )
        );
    }


    /**
     * Get filter types
     *
     * @return array
     */
    private function getTypes(){
        return array(
            self::TYPE_EQ,
            self::TYPE_GT,
            self::TYPE_GE,
            self::TYPE_NE,
            self::TYPE_LT,
            self::TYPE_LE
        );
    }

    /**
     * Get all plate
     *
     * @param int $limit
     * @param int $offset
     * @return array|null
     * @throws \Exception
     */
    public function findAll($limit = 100, $offset = 0){
        //new event getAll
        $url = $this->apiUrl.'?$format='.$this->contentType.'&$top='.$limit.'&$skip='.$offset;
        try {
            $request = $this->client->get($url);
        } catch (RequestException $e) {
            throw new \Exception($e->getMessage());
        }
        $response = $this->client->send($request);
        //new event post getAll
        $json = $response->json();
        if(!isset($json['d'])){
            return null;
        }
        if(!isset($json['d']['results'])){
            return null;
        }
        if(count($json['d']['results']) <= 0){
            return null;
        }
        $kentekens = array();
        foreach($json['d']['results'] as $result){
            $kenteken = new Kenteken();
            foreach($result as $key => $value){
                if(method_exists($kenteken, "set".ucfirst($key))) {
                    call_user_func(array($kenteken, "set" . ucfirst($key)), $value);
                }
            }
            $kentekens[] = $kenteken;
        }
        return $kentekens;
    }

    /**
     * Search for plate(s)
     *
     * @param string $key
     * @param string $value
     * @param string $type
     * @param int $limit
     * @param int $offset
     * @return array|null
     * @throws \Exception
     */
    public function findBy($key, $value, $type = self::TYPE_EQ, $limit = 100, $offset =0){
        //new event pre search
        if(!in_array($type, $this->getTypes())){
            throw new \Exception("Type not found");
        }

        if(!method_exists("Nettob\\Component\\Rdw\\Model\\Kenteken", "get".ucfirst($key))) {
            throw new \Exception("Key not found");
        }
        $url = $this->apiUrl.'?$format='.$this->contentType.'&$top='.$limit.'&$skip='.$offset.'&$filter='.$key.' '.$type.' \''.$value.'\'';
        try {
            $request = $this->client->get($url);
        } catch (RequestException $e) {
            throw new \Exception($e->getMessage());
        }
        $response = $this->client->send($request);
        //new event post search
        $json = $response->json();
        if(!isset($json['d'])){
            return null;
        }
        if(!isset($json['d']['results'])){
            return null;
        }
        if(count($json['d']['results']) <= 0){
            return null;
        }
        $kentekens = array();
        foreach($json['d']['results'] as $result){
            $kenteken = new Kenteken();
            foreach($result as $key => $value){
                if(method_exists($kenteken, "set".ucfirst($key))) {
                    call_user_func(array($kenteken, "set" . ucfirst($key)), $value);
                }
            }
            $kentekens[] = $kenteken;
        }
        return $kentekens;
    }
}