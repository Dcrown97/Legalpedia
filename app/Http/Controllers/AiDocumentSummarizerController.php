<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use OpenAI;
class AiDocumentSummarizerController extends Controller
{

    public static function breakText($text, $minLength = 200, $needle='.') {
        $delimiter = preg_quote($needle);
        $match = preg_match_all("/.*?$delimiter/",$text, $matches);
      
        if ($match == 0)
         return array($text);
      
        $sentences = current($matches);
        $paras = array();
        $tmp = '';
      
        foreach ($sentences as $sentence) {
         $tmp .= $sentence;
         if (strlen($tmp) > $minLength){
          $paras[] = $tmp;
          $tmp = '';
         }
        }
      
        if ($tmp != '')
         $paras[] = $tmp;
        return $paras;
    }

    public static function summarize(String $text)
    {
        // Get the input document text from the request
        $longText = $text;
        // Split the long text into smaller parts (adjust as needed)
        $textParts = static::breakText($longText, 10000);
        // dd($textParts, strlen($longText));
        // Initialize the conversation with a system message
        $conversation = [
            [
                "role" => "system", 
                "content" => "You are a Nigerian lawyer, who works with Judgements from all courts in Nigeria, you summerize case laws, help summerize the following judgement and to itemize all the major issues and principles of law decided on this judgment (the ratio decidendi), based on the Nigerian laws and constitution. Get out at least 8 ratio decidendi from the case and exactly what the court decided on each ratio decidendi. 
                Here is how the output of your response should be
                1. Summarize the judgment
                2. Outline the ratio decidendi from the case and exactly what the court decided on each ratio decidendi (remember to get at least 8 ratio decidendi)"
            ]
        ];

        // foreach ($textParts as $part) {
        //     // Add the user input part to the conversation
        //     $conversation[] = ["role" => "user", "content" => $part];

        //     // Generate a response from the model
        //     $response = OpenAI::completion()->create([
        //         "model" => "text-davinci-003",  // or other appropriate model
        //         "messages" => $conversation,
        //         "temperature" => 0.7,
        //         "max_tokens" => 150,  // Adjust the max_tokens as needed
        //     ]);

        //     // Extract the model's response
        //     $modelResponse = $response['choices'][0]['message']['content'];

        //     // Do something with the model's response (e.g., store, display, etc.)
        //     // For demonstration purposes, let's store them in an array
        //     $summaries[] = $modelResponse;
        // }
        

        // Make a request to the ChatGPT API to summarize the document
        $apiKey = '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';
        $url = 'https://api.openai.com/v1/chat/completions';
        $headers = [
            'Authorization' => 'Bearer ' . $apiKey,
        ];
        foreach ($textParts as $part) {
            // dd($part);
            $conversation[] = ["role" => "user", "content" => $part];
            $client = new Client();
            $response = $client->post($url, [
                'headers' => $headers,
                'json' => [
                    'model'=> "gpt-3.5-turbo-16k",
                    'messages' => $conversation,
                    'max_tokens' => 1000, // Adjust the summary length as needed
                    "temperature" => 0.7,
                ],
            ]);
            $summary = json_decode($response->getBody(), true)['choices'][0]['message']['content'];
            // dd($summary, json_decode($response->getBody(), true), strlen($longText));
            $summaries[] = $summary;
        }
       
        
        // // Extract the summary from the API response
        // $summary = json_decode($response->getBody(), true)['choices'][0]['text'];

        // // Display the summary in your view or return it as a response
        return $summaries;
    }

    public static function summarizeLFN(String $text)
    {
        // Get the input document text from the request
        $longText = $text;
        // Split the long text into smaller parts (adjust as needed)
        $textParts = static::breakText($longText, 10000);
        // dd($textParts, strlen($longText));
        // Initialize the conversation with a system message
        $conversation = [
            [
                "role" => "system", 
                "content" => "You are a Nigerian Lawyer who is a Legal editor for the Laws of the Federation of Nigeria. Please summarize this law and point out the key provisions, principles, and obligations in the law. Highlight any specific terms, conditions, or exceptions that should be noted.

                Then provide an executive summary of the law, focusing on its practical applications and implications. Explain how the law might be interpreted by courts, government agencies, or businesses in Nigeria."
            ]
        ];

        // Make a request to the ChatGPT API to summarize the document
        $apiKey = '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';
        $url = 'https://api.openai.com/v1/chat/completions';
        $headers = [
            'Authorization' => 'Bearer ' . $apiKey,
        ];
        foreach ($textParts as $part) {
            // dd($part);
            $conversation[] = ["role" => "user", "content" => $part];
            $client = new Client();
            $response = $client->post($url, [
                'headers' => $headers,
                'json' => [
                    'model'=> "gpt-3.5-turbo-16k",
                    'messages' => $conversation,
                    'max_tokens' => 1000, // Adjust the summary length as needed
                    "temperature" => 0.7,
                ],
            ]);
            $summary = json_decode($response->getBody(), true)['choices'][0]['message']['content'];
            // dd($summary, json_decode($response->getBody(), true), strlen($longText));
            $summaries[] = $summary;
        }
       
        
        // // Extract the summary from the API response
        // $summary = json_decode($response->getBody(), true)['choices'][0]['text'];

        // // Display the summary in your view or return it as a response
        return $summaries;
    }
}
