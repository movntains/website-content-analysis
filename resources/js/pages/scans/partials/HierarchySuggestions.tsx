interface HierarchySuggestionsProps {
  hierarchyItems: string[];
}

export default function HierarchySuggestions({ hierarchyItems }: HierarchySuggestionsProps) {
  return (
    <div className="space-y-4">
      <h4 className="text-sm font-medium">Hierarchy Suggestions</h4>

      {hierarchyItems.length > 0 && (
        <ul className="list-disc space-y-4 pl-6">
          {hierarchyItems.map((hierarchyItem, index) => (
            <li
              key={`hierarchy-item-${index}`}
              className="text-muted-foreground"
            >
              {hierarchyItem}
            </li>
          ))}
        </ul>
      )}

      {hierarchyItems.length === 0 && <p className="text-muted-foreground">No hierarchy suggestions were provided.</p>}
    </div>
  );
}
