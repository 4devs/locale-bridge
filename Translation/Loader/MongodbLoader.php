<?php

namespace FDevs\Bridge\Locale\Translation\Loader;

use Symfony\Component\Translation\Exception\InvalidResourceException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogue;

class MongodbLoader implements LoaderInterface
{
    /**
     * Loads a locale.
     *
     * @param \MongoDB $resource A resource
     * @param string   $locale   A locale
     * @param string   $domain   The domain
     *
     * @return MessageCatalogue A MessageCatalogue instance
     *
     * @api
     *
     * @throws NotFoundResourceException when the resource cannot be found
     * @throws InvalidResourceException  when the resource cannot be loaded
     */
    public function load($resource, $locale, $domain = 'messages')
    {
        if (!$resource instanceof \MongoDB) {
            throw new InvalidResourceException(sprintf('resource "%s" not support please use "\MongoDB"', $resource));
        }

        $messages = $this->getMessages($resource, $locale, $domain);
        $catalogue = new MessageCatalogue($locale);
        $catalogue->add($messages, $domain);

        return $catalogue;
    }

    /**
     * get messages.
     *
     * @param \MongoDB $resource
     * @param string   $locale
     * @param string   $document
     *
     * @return array
     */
    protected function getMessages(\MongoDB $resource, $locale, $document)
    {
        try {
            $messages = [];
            $trans = $resource->selectCollection($document)->find(['trans.locale' => $locale]);
            foreach ($trans as $line) {
                $data = array_filter($line['trans'], function ($el) use ($locale) {
                    return $el['locale'] === $locale;
                });
                $messages[$line['_id']] = current($data)['text'];
            }
        } catch (\Exception $e) {
            throw new NotFoundResourceException($e->getMessage(), $e->getCode(), $e);
        }

        return $messages;
    }
}
