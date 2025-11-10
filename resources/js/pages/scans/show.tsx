import { Head, usePoll } from '@inertiajs/react';
import { useEffect, useMemo } from 'react';

import { AppContent } from '@/components/app-content';
import Heading from '@/components/heading';
import TextLink from '@/components/text-link';
import AppLayout from '@/layouts/app-layout';
import ScanAnalysis from '@/pages/scans/partials/ScanAnalysis';
import ScanScores from '@/pages/scans/partials/ScanScores';
import ScanStatus from '@/pages/scans/partials/ScanStatus';
import ScanSuggestions from './partials/ScanSuggestions';

import { formatDate } from '@/lib/utils';
import { index, show } from '@/routes/scans';
import type { BreadcrumbItem } from '@/types';
import { ScanStatusEnum } from '@/types/enums/scan';
import type { ScanDetails } from '@/types/scan';

interface ScansShowProps {
  scan: ScanDetails;
}

export default function ScansShow({ scan }: ScansShowProps) {
  const breadcrumbs: BreadcrumbItem[] = [
    {
      title: 'Scans',
      href: index().url,
    },
    {
      title: 'Scan Results',
      href: show(scan).url,
    },
  ];

  const isProcessing = useMemo(() => [ScanStatusEnum.PENDING, ScanStatusEnum.PROCESSING].includes(scan.status), [scan]);

  const { stop } = usePoll(2000);

  useEffect(() => {
    if (!isProcessing) {
      stop();
    }
  }, [isProcessing, stop]);

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="URL Scan Results" />

      <AppContent>
        <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
          <div className="mb-6 flex items-start justify-between">
            <Heading
              title="URL Scan Results"
              level="h1"
              description="The results of your scan."
            />

            <TextLink href={index().url}>Back to URL Scans</TextLink>
          </div>

          <div className="mb-6 space-y-2">
            <Heading
              title={scan.url}
              description={`Scanned on ${formatDate(scan.createdAt).toLocaleString()}`}
            />

            <ScanStatus status={scan.status} />
          </div>

          {/*  TODO: Add processing state */}

          {/*  TODO: Add failed state */}

          {scan.status === ScanStatusEnum.COMPLETED && (
            <div className="space-y-10">
              <ScanScores scores={scan.scores} />
              <ScanAnalysis analysis={scan.analysis} />
              <ScanSuggestions suggestions={scan.suggestions} />
            </div>
          )}
        </div>
      </AppContent>
    </AppLayout>
  );
}
