import { Badge } from '@/components/ui/badge';

import { cn } from '@/lib/utils';
import { ScanStatusEnum } from '@/types/enums/scan';

interface ScanStatusProps {
  status: ScanStatusEnum;
  classes?: string;
}

export default function ScanStatus({ status, classes = '' }: ScanStatusProps) {
  const statusColors: Record<ScanStatusEnum, string> = {
    pending: 'bg-yellow-100 text-yellow-800',
    processing: 'bg-blue-100 text-blue-800',
    completed: 'bg-green-100 text-green-800',
    failed: 'bg-red-100 text-red-800',
  };

  return <Badge className={cn('capitalize', classes, statusColors[status])}>{status}</Badge>;
}
