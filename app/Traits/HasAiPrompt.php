<?php

namespace App\Traits;


use App\Models\Language;
use Dipokhalder\Settings\Facades\Settings;

trait HasAiPrompt
{

    public string $langName = 'English';

    public string $langCode = 'EN';

    public function loadDefaultLanguage(): void
    {
        $defaultLanguage = Settings::group('site')->get('site_default_language');
        $language = Language::find($defaultLanguage);
        if($language) {
            $this->langName = $language->name;
            $this->langCode = strtoupper($language->code);
        }
    }

    public function buildProductNamePrompt(string $name): string
    {
        return <<<PROMPT
          You are a professional food menu copywriter for a food delivery platform.

          Rewrite the food menu name "{$name}" as a creative, appealing, and concise food menu title.

          CRITICAL INSTRUCTION:
          - The output must be 100% in language "{$this->langName}" (Code: {$this->langCode}) — this is mandatory.
          - If the original name is not in "{$this->langName}", fully translate it into "{$this->langName}" while keeping the appealing meaning.
          - Do not mix languages; use only "{$this->langName}" characters and words.
          - Keep it short (3-8 words), appealing, and ready for a product listing.
          - No extra words, slogans, or punctuation like quotes.
          - Return only the translated title as plain text in "{$this->langName}".

      IMPORTANT:
        - Only process inputs that are actual food items, beverages, or restaurant meals.
        - If the input is unrelated or cannot be converted into a product title, respond with only "INVALID_INPUT".
        - Do not return generic explanations, fallback messages, or translations for invalid items.
      PROMPT;
    }

    public function buildProductDescriptionPrompt(string $description): string
    {
       return <<<PROMPT
        You are a creative and professional food menu copywriter for a food delivery platform.

        Generate a short, engaging, and persuasive description for the food item named "{$description}".

        CRITICAL LANGUAGE RULES:
        - The entire description must be written 100% in {$this->langName} (Code: {$this->langCode}) — this is mandatory.
        - If the food name is in another language, translate and localize it naturally into {$this->langName}.
        - Do not mix languages; use only {$this->langName} characters and words.
        - Adapt the tone, phrasing, and examples to be natural for {$this->langName} readers.

        Content & Structure:
        - Write a concise paragraph (2-4 sentences) describing the taste, aroma, key ingredients, and appeal of the dish.
        - Highlight what makes it special or delicious.
        - Keep it appetizing and suitable for a food menu.
        - Do not start with or repeat the item name "{$description}".

        Formatting:
        - Output plain text only, no HTML tags, markdown, or special formatting.
        - Use natural sentence structure with proper punctuation.
        - Keep it brief and engaging.
        - Return only the plain text description without any commentary.

         IMPORTANT:
        - Only process inputs that are actual food items, beverages, or restaurant meals.
        - If the input is electronics, clothing, gadgets, or anything unrelated to food, respond with only "INVALID_INPUT".
        - If the original input is not meaningful or cannot be converted into a food menu description, respond with only "INVALID_INPUT".
        - Do not return generic explanations, fallback messages, or translations for unrelated items.
        PROMPT;
    }

    public function buildProductCautionPrompt(string $caution): string
    {
       return <<<PROMPT
        You are a creative and professional food menu copywriter for a food delivery platform.

        Generate a short, clear, and customer-safe caution note for the food item named "{$caution}".

        CRITICAL LANGUAGE RULES:
        - The entire caution note must be written 100% in {$this->langName} (Code: {$this->langCode}) — this is mandatory.
        - If the food name is in another language, translate and localize it naturally into {$this->langName}.
        - Do not mix languages; use only {$this->langName} characters and words.
        - Adapt the tone, phrasing, and examples to be natural for {$this->langName} readers.

        Content & Structure:
        - Write a concise warning (1-2 sentences) about allergens, spice level, dietary restrictions, or serving notes.
        - Mention any relevant caution points such as dairy, gluten, nuts, shellfish, spiciness, or temperature.
        - Keep it helpful, polite, and suitable for a food menu or order note.
        - Do not start with or repeat the item name "{$caution}".

        Formatting:
        - Output plain text only, no HTML tags, markdown, or special formatting.
        - Use natural sentence structure with proper punctuation.
        - Keep it brief and direct.
        - Return only the plain text caution note without any commentary.

         IMPORTANT:
        - Only process inputs that are actual food items, beverages, or restaurant meals.
        - If the input is electronics, clothing, gadgets, or anything unrelated to food, respond with only "INVALID_INPUT".
        - If the original input is not meaningful or cannot be converted into a food menu caution note, respond with only "INVALID_INPUT".
        - Do not return generic explanations, fallback messages, or translations for unrelated items.
        PROMPT;
    }
}
