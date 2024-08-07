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
        set_time_limit(600);
        // Get the input document text from the request
        $longText = $text;
        // Split the long text into smaller parts (adjust as needed)
        $textParts = static::breakText($longText, 10000);
        // dd($textParts, strlen($longText));
        // Initialize the conversation with a system message
        $conversation = [
            [
                "role" => "system", 
                "content" => "You are a Nigerian lawyer, who works with Judgements from all courts in Nigeria, you analyze and summarize case laws based on the Nigerian laws and constitution, Analyze and summarize this case law, and here is how your response should go (well formatted in html with adequate spacing)
                Case Background:
                What are the essential facts of the case?
                What legal issues are being disputed?
                What were the arguments presented by both parties?
                Identifying Ratio Decidendi:
                Get at least 8 ratio decidendi
                What are the key principles of law that were applied to this case?
                What legal precedent or statutory law guided the court's decision?
                What were the specific findings of fact that led to the decision?
                Exploring the Ratios:
                For each ratio decidendi, how did the court interpret and apply the relevant laws or precedents?
                What were the court's specific reasoning and conclusions on each ratio decidendi?
                How does each ratio decidendi align with existing Nigerian laws and the constitution?
                Assessing the Implications:
                What is the broader legal significance of this judgment?
                How might this decision influence future cases in similar legal contexts?
                Are there any dissenting or concurring opinions that provide additional insights or contrasting viewpoints?
                Summarizing the Judgment:
                What is a concise summary of the court's decision that encapsulates the essential points?
                How does this case contribute to or alter the existing body of case law in Nigeria?
                Reviewing Subsequent Developments:
                Have there been any subsequent cases, statutes, or legal developments that have built upon or challenged the principles laid out in this case?"
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
                    'max_tokens' => 1500, // Adjust the summary length as needed
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
        // dd();
        return $summaries;
    }

    public static function summarizeLFN(String $text)
    {
        set_time_limit(600);
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

                Then provide an executive summary of the law, focusing on its practical applications and implications. Explain how the law might be interpreted by courts, government agencies, or businesses in Nigeria. (Well formatted in html with adequate spacing)"
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

    public static function summarizeAgreement(String $text)
    {
        set_time_limit(600);
        // Get the input document text from the request
        $longText = $text;
        // Split the long text into smaller parts (adjust as needed)
        $textParts = static::breakText($longText, 10000);
        // dd($textParts, strlen($longText));
        // Initialize the conversation with a system message
        $conversation = [
            [
                "role" => "system", 
                "content" => "You are a Nigerian lawyer who analysis legal agreements. Please analyse this agreement and do the following (in well formatted in html with adequate spacing);
                Identify and highlight the crucial points in the following legal agreement from the context of the Federation of Nigeria. Emphasize any terms, conditions, or obligations that are particularly significant or may have substantial legal implications.
                Extract and detail the specific clauses from the legal agreement. For each clause, define the expectations from each party, the obligations they are under, and any potential penalties or remedies for non-compliance.
                Provide a comprehensive summary of the legal agreement. Include an overview of the main obligations, rights, penalties, dispute resolution mechanisms, and any specific provisions that set this agreement apart.
                Analyze the legal agreement and compare its clauses with standard or commonly accepted practices in the legal jurisdiction of the Federation of Nigeria. Highlight any unusual or unique clauses, and explain their potential implications or risks.
                Interpret the  legal agreement, identifying any potential issues, ambiguities, or contradictions that may arise. Provide insights into how different provisions might interact, and highlight any areas that may require clarification or further negotiation."
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

    public static function summarizeText(String $text)
    {
        set_time_limit(600);
        // Get the input document text from the request
        $longText = $text;
        // Split the long text into smaller parts (adjust as needed)
        $textParts = static::breakText($longText, 10000);
        // dd($textParts, strlen($longText));
        // Initialize the conversation with a system message
        $conversation = [
            [
                "role" => "system", 
                "content" => "Please summarize this content to minimum of 6 pages"
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
