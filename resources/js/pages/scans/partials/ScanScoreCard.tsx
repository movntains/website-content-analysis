import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

interface ScanScoreCardProps {
  scoreName: string;
  scoreValue: string;
  scoreMaxValue?: number;
}

export default function ScanScoreCard({ scoreName, scoreValue, scoreMaxValue = 100 }: ScanScoreCardProps) {
  return (
    <Card>
      <CardHeader>
        <CardTitle>
          <h4>{scoreName}</h4>
        </CardTitle>

        <CardDescription>
          The content score for {scoreName.toLowerCase()} out of {scoreMaxValue}.
        </CardDescription>
      </CardHeader>

      <CardContent>
        <p className="text-lg font-medium">
          {Number(scoreValue)}/{scoreMaxValue}
        </p>
      </CardContent>
    </Card>
  );
}
