import HeadingSmall from '@/components/heading-small';
import CTASuggestions from './CTASuggestions';
import HeadlineSuggestions from './HeadlineSuggestions';
import HierarchySuggestions from './HierarchySuggestions';

interface ScanSuggestionsProps {
  suggestions: {
    headlines: string[];
    ctas: string[];
    hierarchy: string[];
  };
}

export default function ScanSuggestions({ suggestions }: ScanSuggestionsProps) {
  return (
    <div className="space-y-4">
      <HeadingSmall title="Content Suggestions" />

      <HeadlineSuggestions headlines={suggestions.headlines} />
      <CTASuggestions ctas={suggestions.ctas} />
      <HierarchySuggestions hierarchyItems={suggestions.hierarchy} />
    </div>
  );
}
