<?php

namespace Devzkhalil\TrovitXmlFeed;

use XMLWriter;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Collection;

class TrovitXmlFeed
{
    /**
     * Generate XML feed from data and save to file.
     *
     * @param array|Collection $data
     * @param string $file_name
     * @return array
     */
    public function generate($data, string $file_name): array
    {
        // Convert Collection to array if necessary
        if ($data instanceof Collection) {
            $data = $data->toArray();
        }

        // Retrieve fields from configuration
        $fields = $this->getFields();
        $fieldMapping = $this->getFieldMapping();

        try {
            // Create and open XMLWriter
            $xml = new XMLWriter();
            $xmlFilePath = public_path("{$file_name}.xml");
            $xml->openURI($xmlFilePath);

            // Start the document
            $xml->startDocument('1.0', 'UTF-8');
            $xml->startElement('trovit');

            // Process each item in the data array
            foreach ($data as $item) {
                $this->processItem($xml, $item, $fields, $fieldMapping);
            }

            // End the root element and close the document
            $xml->endElement();
            $xml->endDocument();
            $xml->flush();

            return [
                'status' => true,
                'message' => 'success'
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage()
            ];
        }
    }

    /**
     * Process each item and add it to the XML.
     *
     * @param XMLWriter $xml
     * @param array $item
     * @param array $fields
     * @param array $fieldMapping
     */
    private function processItem(XMLWriter $xml, array $item, array $fields, array $fieldMapping): void
    {
        $xml->startElement('ad');

        // Add each field as a child element of 'ad'
        $this->addFieldsToItem($xml, $item, $fields, $fieldMapping);

        $xml->endElement();
    }

    /**
     * Add fields to a single XML item.
     *
     * @param XMLWriter $xml
     * @param array $item
     * @param array $fields
     * @param array $fieldMapping
     */
    private function addFieldsToItem(XMLWriter $xml, array $item, array $fields, array $fieldMapping): void
    {
        foreach ($fields as $field) {
            // Map database field to XML field using the fieldMapping, default to the same field name
            $dbField = array_search($field, $fieldMapping, true) ?: $field;

            // Ensure the field exists in the item and add CDATA-wrapped value
            if (isset($item[$dbField])) {
                $xml->startElement($field);
                $xml->writeCdata($item[$dbField]);
                $xml->endElement();
            }
        }
    }

    /**
     * Get fields from configuration.
     *
     * @return array
     */
    private function getFields(): array
    {
        return Config::get('trovit.fields', []);
    }

    /**
     * Get field mapping from configuration.
     *
     * @return array
     */
    private function getFieldMapping(): array
    {
        return Config::get('trovit.field_mapping', []);
    }
}
