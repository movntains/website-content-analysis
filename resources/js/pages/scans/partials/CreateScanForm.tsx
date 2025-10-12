import { useForm } from '@inertiajs/react';
import { FormEvent } from 'react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import { store } from '@/actions/App/Http/Controllers/ScanController';

export default function CreateScanForm() {
  const { clearErrors, data, errors, processing, reset, setData, submit } = useForm<{
    url: string;
  }>({
    url: '',
  });

  const handleSubmit = (e: FormEvent) => {
    e.preventDefault();

    submit(store(), {
      onSuccess: () => {
        clearErrors();
        reset();
      },
    });
  };

  return (
    <form
      noValidate
      className="space-y-6"
      onSubmit={handleSubmit}
    >
      <div className="grid grid-cols-6 gap-3">
        <Label
          htmlFor="url"
          className="col-span-6"
        >
          URL to Scan
        </Label>

        <Input
          id="url"
          type="url"
          value={data.url}
          onChange={(e) => {
            clearErrors('url');

            setData('url', e.target.value);
          }}
          placeholder="https://example.com"
          className="col-span-3"
          required
        />

        <InputError
          message={errors.url}
          className="col-span-6"
        />
      </div>

      <div>
        <Button
          type="submit"
          variant="default"
          disabled={processing}
        >
          Start Scan
        </Button>
      </div>
    </form>
  );
}
