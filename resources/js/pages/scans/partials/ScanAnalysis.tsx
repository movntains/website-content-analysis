import HeadingSmall from '@/components/heading-small';
import ScanAnalysisCard from '@/pages/scans/partials/ScanAnalysisCard';

interface ScanAnalysisProps {
  analysis: {
    clarity: string;
    consistency: string;
    seo: string;
    tone: string;
  };
}

export default function ScanAnalysis({ analysis }: ScanAnalysisProps) {
  return (
    <div className="space-y-4">
      <HeadingSmall title="Content Analysis" />

      <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
        <ScanAnalysisCard
          analysisName="Clarity"
          analysisValue={analysis.clarity}
        />
        <ScanAnalysisCard
          analysisName="Consistency"
          analysisValue={analysis.consistency}
        />
        <ScanAnalysisCard
          analysisName="SEO"
          analysisValue={analysis.seo}
        />
        <ScanAnalysisCard
          analysisName="Tone"
          analysisValue={analysis.tone}
        />
      </div>
    </div>
  );
}
