import { PropsWithChildren } from 'react';

import { cn } from '@/lib/utils';

interface ListCardItemProps {
  classes?: string;
}

export default function ListCardItem({ children, classes }: PropsWithChildren<ListCardItemProps>) {
  return <div className={cn('flex items-center justify-between gap-2 py-4 text-sm', classes)}>{children}</div>;
}
