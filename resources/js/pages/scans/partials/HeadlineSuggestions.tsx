interface HeadlineSuggestionsProps {
  headlines: string[];
}

export default function HeadlineSuggestions({ headlines }: HeadlineSuggestionsProps) {
  return (
    <div className="space-y-4">
      <h4 className="text-sm font-medium">Headline Suggestions</h4>

      {headlines.length > 0 && (
        <ul className="list-disc space-y-4 pl-6">
          {headlines.map((headline, index) => (
            <li
              key={`headline-${index}`}
              className="text-muted-foreground"
            >
              {headline}
            </li>
          ))}
        </ul>
      )}

      {headlines.length === 0 && <p className="text-muted-foreground">No headline suggestions were provided.</p>}
    </div>
  );
}
