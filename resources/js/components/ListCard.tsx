import { PropsWithChildren, ReactNode } from 'react';

import { Card, CardContent, CardHeader } from '@/components/ui/card';

interface ListCardProps {
  header: ReactNode;
}

export default function ListCard({ children, header }: PropsWithChildren<ListCardProps>) {
  return (
    <Card>
      <CardHeader className="space-y-2 border-b pb-4">{header}</CardHeader>

      <CardContent>
        <dl className="divide-y">{children}</dl>
      </CardContent>
    </Card>
  );
}
