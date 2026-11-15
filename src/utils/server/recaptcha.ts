import { RECAPTCHA_SECRET_KEY, RECAPTCHA_VERIFY_URL } from 'astro:env/server';
import { env } from 'cloudflare:workers';

const MIN_SCORE = 0.5;

/** Verifies a reCAPTCHA v3 token server-side. `action` must match what the browser asked for. */
export async function verifyRecaptcha(token: unknown, action: string): Promise<boolean> {
  if (!RECAPTCHA_SECRET_KEY || typeof token !== 'string' || !token) {
    // Names only, never values: shows which settings the running Worker can actually see.
    console.warn('recaptcha: missing', {
      hasSecret: !!RECAPTCHA_SECRET_KEY,
      hasToken: typeof token === 'string' && !!token,
      workerSettings: Object.keys(env as Record<string, unknown>),
    });
    return false;
  }
  try {
    const res = await fetch(RECAPTCHA_VERIFY_URL || 'https://www.google.com/recaptcha/api/siteverify', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ secret: RECAPTCHA_SECRET_KEY, response: token }),
    });
    const data = (await res.json()) as { success?: boolean; score?: number; action?: string; 'error-codes'?: string[] };
    console.warn('recaptcha: result', { success: data.success, score: data.score, action: data.action, errors: data['error-codes'] });
    return data.success === true && data.action === action && (data.score ?? 0) >= MIN_SCORE;
  } catch (err) {
    console.warn('recaptcha: verify failed', err);
    return false;
  }
}
