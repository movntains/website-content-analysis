import HeadingSmall from '@/components/heading-small';
import ScanScoreCard from '@/pages/scans/partials/ScanScoreCard';

interface ScanScoresProps {
  scores: {
    clarity: string;
    consistency: string;
    seo: string;
    tone: string;
  };
}

export default function ScanScores({ scores }: ScanScoresProps) {
  return (
    <div className="space-y-4">
      <HeadingSmall title="Content Scores" />

      <div className="grid grid-cols-1 gap-4 md:grid-cols-4">
        <ScanScoreCard
          scoreName="Clarity"
          scoreValue={scores.clarity}
        />
        <ScanScoreCard
          scoreName="Consistency"
          scoreValue={scores.consistency}
        />
        <ScanScoreCard
          scoreName="SEO"
          scoreValue={scores.seo}
        />
        <ScanScoreCard
          scoreName="Tone"
          scoreValue={scores.tone}
        />
      </div>
    </div>
  );
}
