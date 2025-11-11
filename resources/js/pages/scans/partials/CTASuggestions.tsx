interface CTASuggestionsProps {
  ctas: string[];
}

export default function CTASuggestions({ ctas }: CTASuggestionsProps) {
  return (
    <div className="space-y-4">
      <h4 className="text-sm font-medium">CTA Suggestions</h4>

      {ctas.length > 0 && (
        <ul className="list-disc space-y-4 pl-6">
          {ctas.map((cta, index) => (
            <li
              key={`cta-${index}`}
              className="text-muted-foreground"
            >
              {cta}
            </li>
          ))}
        </ul>
      )}

      {ctas.length === 0 && <p className="text-muted-foreground">No CTA suggestions were provided.</p>}
    </div>
  );
}
