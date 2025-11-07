import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

interface ScanAnalysisCardProps {
  analysisName: string;
  analysisValue: string;
}

export default function ScanAnalysisCard({ analysisName, analysisValue }: ScanAnalysisCardProps) {
  return (
    <Card className="col-span-2 md:col-span-1">
      <CardHeader>
        <CardTitle>
          <h4>{analysisName} Analysis</h4>
        </CardTitle>
      </CardHeader>

      <CardContent>
        <p className="text-muted-foreground">{analysisValue}</p>
      </CardContent>
    </Card>
  );
}
