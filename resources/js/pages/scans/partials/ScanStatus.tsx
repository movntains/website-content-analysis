import { Badge } from '@/components/ui/badge';

import { cn } from '@/lib/utils';
import type { ScanStatus as ScanStatusType } from '@/types/scan';

interface ScanStatusProps {
  status: ScanStatusType;
  classes?: string;
}

export default function ScanStatus({ status, classes = '' }: ScanStatusProps) {
  const statusColors: Record<ScanStatusType, string> = {
    pending: 'bg-yellow-100 text-yellow-800',
    processing: 'bg-blue-100 text-blue-800',
    completed: 'bg-green-100 text-green-800',
    failed: 'bg-red-100 text-red-800',
  };

  return <Badge className={cn('capitalize', classes, statusColors[status])}>{status}</Badge>;
}
