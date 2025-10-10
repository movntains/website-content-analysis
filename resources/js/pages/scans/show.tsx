import { Head, usePoll } from '@inertiajs/react';

import { AppContent } from '@/components/app-content';
import Heading from '@/components/heading';
import AppLayout from '@/layouts/app-layout';

import { index, show } from '@/routes/scans';
import type { BreadcrumbItem } from '@/types';
import { useEffect, useMemo } from 'react';

interface ScansShowProps {
  scan: any;
}

export default function ScansShow({ scan }: ScansShowProps) {
  const breadcrumbs: BreadcrumbItem[] = [
    {
      title: 'Scans',
      href: index().url,
    },
    {
      title: 'Scan Results',
      href: show(scan.id).url,
    },
  ];

  const isProcessing = useMemo(() => ['pending', 'processing'].includes(scan.status), [scan]);

  const { stop } = usePoll(2000);

  useEffect(() => {
    console.log(isProcessing);
    if (!isProcessing) {
      stop();
    }
  }, [isProcessing, stop]);

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="URL Scan Results" />

      <AppContent>
        <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
          <Heading
            title="URL Scan Results"
            level="h1"
            description="The results of your scan."
          />

          {scan.status}
        </div>
      </AppContent>
    </AppLayout>
  );
}
